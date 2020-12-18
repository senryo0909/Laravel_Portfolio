<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function showLoginForm()
    {
        
        return view('user.auth.login');
    }
    
 
    protected function guard()
    {
        //user用のguard変更をIlluminate\Support\Facades\Authからオーバーライド
        return Auth::guard('user');
    }

    // マルチ認証のため、ログアウト処理を分離。namespace Illuminate\Foundation\Auth\AuthenticatesUsersトレイトのloggoutメソッドをオーバーライド
    
     public function logout(Request $request)
    {
        // Auth::guard('user')->logout();
        //Userからログアウトのリクエストがきたら。
        $this->guard('user')->logout();
        
        //sessionを作り直し
        $request->session()->invalidate();
        
        //トークンの作り直し
        $request->session()->regenerateToken();
        
        //loggedOutメソッドをオーバーライドで呼び出し、/へリダイレクト
        return $this->loggedOut($request);
        
    }
    public function loggedOut(Request $request)
    {
        return redirect('/');
    }

}
