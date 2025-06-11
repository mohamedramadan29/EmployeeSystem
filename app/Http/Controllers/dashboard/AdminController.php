<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\dashboard\Task;
use App\Models\dashboard\Admin;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
     // Use Trait For Success Or Error Messages
     use Message_Trait;

     public function dashboard(){
        $inProgressOrders = 0;
        $employeeEarnings = 0;
        $totalEarnings = 0;
        $totalEmployees = Admin::where('account_type', 'employee')->count();
        $totalOrders = Task::count();
        $completedOrders = Task::where('status', 'مكتمل')->count();
        $totalEarnings = Task::sum('price');
        $orders = Task::orderBy('id', 'desc')->take(5)->get();
        ######### Employees Datat

        if(Auth::guard('admin')->user()->account_type == 'employee'){

            $tasks = Task::where('employe_id', Auth::guard('admin')->user()->id)->get();
            $totalOrders = $tasks->count();
            $completedOrders = $tasks->where('status', 'مكتمل')->count();
            $inProgressOrders = $tasks->where('status', 'قيد التنفيذ')->count();
            $totalEarnings = $tasks->sum('price');
            $orders = Task::where('employe_id', Auth::guard('admin')->user()->id)->orderBy('id', 'desc')->take(5)->get();
        }
        return view('dashboard.welcome', compact('totalEmployees', 'totalOrders', 'completedOrders', 'totalEarnings', 'orders','inProgressOrders'));
     }

     ////////////////////// Login Admin //////////////
     public function login(Request $request)
     {
         if ($request->isMethod('post')) {
             //            $data = $request->all();
             $rules = [
                 'email' => 'required|email',
                 'password' => 'required',
             ];
             $customMessage = [
                 'email.required' => 'من فضلك ادخل البريد الإلكتروني',
                 'email.email' => 'من فضلك ادخل بريد الكتوني صحيح',
                 'password.required' => 'من فضلك ادخل كلمة المرور',
             ];
             $validator = Validator::make($request->all(), $rules, $customMessage);
             if ($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
             }
             $email = $request->email;
             $password = $request->password;


             if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
                 if (Auth::guard('admin')->user()->account_type == 'employee' && Auth::guard('admin')->user()->status == '0') {
                     $this->Error_message(' من فضلك انتظر التفعيل من الادارة   ');
                 } else {
                     return redirect()->route('welcome');
                 }
             } else {
                 //$this->Error_message(' لا يوجد حساب بهذه البيانات  ');
                 return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات  ');
             }
         }

         return view('dashboard.login');
     }

     // check admin password in client side
     public function check_admin_password(Request $request)
     {
         $data = $request->all();
         $old_password = $data['current_password'];
         if (Hash::check($old_password, Auth::guard('admin')->user()->password)) {
             return "true";
         } else {
             return "false";
         }
     }

     /////// Update Admin Password /////////////
     public function update_admin_password(Request $request)
     {
         if ($request->isMethod('post')) {

             $request_data = $request->all();
             //check if old password is correct or not
             if (Hash::check($request_data['old_password'], Auth::guard('admin')->user()->password)) {
                 // check if the new password == confirm password
                 if ($request_data['new_password'] == $request_data['confirm_password']) {
                     $admin_user = Admin::where('id', Auth::guard('admin')->user()->id);
                     $admin_user->update([
                         'password' => bcrypt($request_data['new_password'])
                     ]);
                   return  $this->success_message('تم تعديل كلمة المرور بنجاح');
                 } else {
                    return Redirect::back()->withErrors('يجب تأكيد كلمة المرور بشكل صحيح');
                 }
             } else {
                return Redirect::back()->withErrors('كلمة المرو القديمة غير صحيحة');
             }
         }
         $admin_data = Admin::where('email', Auth::guard('admin')->user()->email)->first();
         return view('dashboard.profile.update', compact('admin_data'));
     }

     ///////////////// Update Admin Details  //////////
     public function update_admin_details(Request $request)
     {
         $admin_data = Admin::where('id', Auth::guard('admin')->user()->id)->first();
         $id = $admin_data['id'];
         if ($request->isMethod('post')) {
             $all_update_data = $request->all();
             ////////////////////// Make Validation //////////////
             $rules = [
                 'name' => 'required|regex:/^[\pL\s\-]+$/u',
                 'email' => 'required|email|unique:admins,email,' . $id,
                 'phone' => 'required|numeric|digits_between:8,14',
                 'address' => 'required',
                 'birth_date' => 'required',
             ];
             $customeMessage = [
                 'name.required' => 'من فضلك ادخل الأسم',
                 'name.regex' => 'من فضلك ادخل الأسم بشكل صحيح ',
                 'email.required' => 'من فضلك ادخل البريد الألكتروني',
                 'email.email' => 'من فضلك ادخل البريد الألكتروني بشكل صحيح',
                 'email.unique' => 'هذا البريد الألكتروني موجود من قبل من فضلك ادخل بريد الكتروني جديد',
                 'phone.required' => 'من فضلك ادخل رقم الهاتف',
                 'phone.digits_between' => 'رقم الهاتف يجب ان يكون من 8 الي 14 رقم',
                 'address.required' => 'من فضلك ادخل العنوان',
                 'birth_date.required' => 'من فضلك ادخل تاريخ الميلاد',
             ];
            $validator = Validator::make($all_update_data , $rules ,$customeMessage);
            if($validator->fails()){
                return Redirect()->back()->withErrors($validator)->withInput();
            }
             $admin_data->update([
                 'name' => $all_update_data['name'],
                 'email' => $all_update_data['email'],
                 'phone' => $all_update_data['phone'],
                 'address' => $all_update_data['address'],
                 'birth_date' => $all_update_data['birth_date'],
             ]);
             return $this->success_message('تم تحديث البيانات بنجاح');
             //            return redirect()->back()->with(['Success_message'=>'']);
         }
         return view('dashboard.profile.update', compact('admin_data'));
     }

     ////////////////// View Admins , Sub Admins , Vendors
     ///
     ///
     public function admins($type = null)
     {
         if ($type != null) {
             $admins = Admin::where('type', $type)->get();
             $title = ucfirst($type);
         }
         if ($type == 'all') {
             $admins = Admin::all();
             $title = 'مشاهدة الكل ';
         }
         //        dd($admins);
         return view('admin.admins.admins', compact('admins', 'title'));
     }
     /////////////////// Logout Admin /////////////////////
     ///
     public function logout()
     {
         Auth::guard('admin')->logout();
         return redirect('dashboard/login');
     }
}
