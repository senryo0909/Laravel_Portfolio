<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

     //ログイン中にログインフォームへアクセスしたときのアクセス振り先の指定
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && $guard === 'user'){
            return redirect('user/home');
        }elseif (Auth::guard($guard)->check() && $guard === 'admin'){
            return redirect('admin/home');
        }
        return $next($request);
    }
    //     switch ($guard) {
    //         case 'admin':
    //             $redirectPath = '/admin/home';
    //             break;
    //         case 'user';
    //             $redirectPath = '/user/home';
    //         default:
    //             $redirectPath = '/user/home';
    //             break;
    //     }
    //     if (Auth::guard($guard)->check()) {
    //         // return redirect('/home');
    //         return redirect($redirectPath);
    //     }

    //     return $next($request);
    // }
}
