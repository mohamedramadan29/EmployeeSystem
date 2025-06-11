<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'=>Admin::class,
        ]);
        // $middleware->redirectGuestsTo(function(){
        //     if(request()->is('*/dashboard/*')){
        //         return route('admin_login');
        //     }else{
        //         //return route('login');
        //     }
        // });
        // $middleware->redirectUsersTo(function(){
        //    if(Auth::guard('admin')->check()){
        //     return to_route('welcome');
        //    }else{
        //     return to_route('admin_login');
        //    }
        // });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
