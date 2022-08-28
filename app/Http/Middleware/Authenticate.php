<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

    //redirect先を同クラス内と継承先クラスの メソッド からのアクセス可能なprotectedで指定
    protected $user_route  = 'user.login';
    protected $admin_route = 'admin.login';

     //middlewareが未認証ユーザーのアクセスをキャッチしたときのリダイレクト先の指定
    protected function redirectTo($request)
    {
        
    if (!$request->expectsJson()) {
        if (Route::is('user.login')) {
            return route($this->user_route);
        } elseif (Route::is('admin.login')) {
            return route($this->admin_route);
        }
    }
  
}
 // if($request->expectsJson()){
    //     return response()->json(['message' => $exception->getMessage()], 401);
    // }

    // if (in_array('admin', $exception->guard())) {
    //     return redirect()->guest(route('admin.login'));
    // }
    // if (in_array('user', $exception->guard())){
    //     return redirect()->guest(route('user.login'));
    // }
   
}

