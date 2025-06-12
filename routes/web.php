<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\TaskController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\ReportController;
use App\Http\Controllers\dashboard\EmployeeController;
use App\Http\Controllers\dashboard\CalcProfitController;
use App\Http\Controllers\dashboard\EmployeeTaskController;

Route::get('/', function () {
    return view('dashboard.login');
});

Route::group(['prefix' => 'dashboard'], function () {
    // Admin Login

    Route::controller(AdminController::class)->group(function () {
        Route::match(['post', 'get'], 'login', 'login')->name('admin_login');
        // Admin Dashboard
        Route::group(['middleware' => 'admin'], function () {
            Route::get('welcome', 'dashboard')->name('welcome');
            // update admin password
            Route::match(['post', 'get'], 'update_admin_password', 'update_admin_password')->name('update_password');
            // check Admin Password
            Route::post('check_admin_password', 'check_admin_password');
            // Update Admin Details
            Route::match(['post', 'get'], 'update_admin_details', 'update_admin_details')->name('update_profile');
            Route::get('logout', 'logout')->name('logout');
        });
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::group([
            'middleware' => function ($request, $next) {
                $user = Auth::guard('admin')->user();

                // إذا كان المستخدم "cashier"، السماح فقط بمسارات الطلبات ومنعه من غيرها
                if ($user->account_type == 'employee' && !request()->is('dashboard/tasks*') && !request()->is('dashboard/task*')) {
                    return abort(403, 'غير مصرح لك بزيارة الصفحة');
                }

                // إذا لم يكن المستخدم "admin" أو "cashier"، منعه من الدخول
                if (!in_array($user->account_type, ['admin', 'employee'])) {
                    return abort(403, 'غير مصرح لك بزيارة الصفحة');
                }

                return $next($request);
            }
        ], function () {
            ////////////////////// Start Products ///////////////////////////////
            Route::controller(TaskController::class)->group(function () {
                Route::get('tasks', 'index')->name('tasks');
                Route::match(['post', 'get'], 'task/add', 'store')->name('task.store');
                Route::match(['post', 'get'], 'task/update/{id}', 'update')->name('task.update');
                Route::match(['post', 'get'], 'task/show/{id}', 'show')->name('task.show');
                Route::get('task/delete/{id}', 'delete')->name('task.delete');
            });
            ///////////////// Start Public Settings
            ///////////////////// Start Order Controller ///////////////
            ///
            Route::controller(EmployeeTaskController::class)->group(function () {
                Route::get('employee-tasks', 'index')->name('employee-tasks');
                Route::post('employee-task/delete/{id}', 'delete');
                Route::match(['post', 'get'], 'employee-task/update/{id}', 'update');
                Route::match(['post', 'get'], 'employee-task/store', 'store');
                Route::get('employee-task/print/{id}', 'print');
                Route::get('employee-tasks/archive', 'archive');
            });

            Route::controller(EmployeeController::class)->group(function () {
                Route::get('employees', 'index')->name('employees');
                Route::match(['post', 'get'], 'employee/store', 'store')->name('employee.store');
                Route::match(['post', 'get'], 'employee/update/{id}', 'update')->name('employee.update');
                Route::get('employee/delete/{id}', 'delete')->name('employee.delete');
            });
            Route::controller(CalcProfitController::class)->group(function () {
                Route::get('calc-profit', 'index')->name('calc-profit');
            });
            Route::controller(ReportController::class)->group(function () {
                Route::get('reports', 'index')->name('reports');
            });
            ############ End Employee Controller
        });
    });

});
