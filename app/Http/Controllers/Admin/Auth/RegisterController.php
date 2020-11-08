<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
//
use App\Providers\RouteServiceProvider;
// 


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    protected function guard()
    {
        //admin用のguard変更をIlluminate\Support\Facades\Authからオーバーライド
        return Auth::guard('admin'); 
    }
    
    public function showRegistrationForm()
    {
        
        return view('admin.auth.register'); 
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    
}
//registerは、入力を受付->登録->指定のページに反映の流れ。
//RegistersUsers;というトレイトをuseし、そのメソッドを使って、登録->指定ページへ反映させてる。
//登録はRegisterUsersのregisterメソッド。登録に追加の処理を記載するにはトレイト最後にあるgesteredメソッド。
//ここは通常ではからのため、return $this->registered($request, $user)?: redirect($this->redirectPath());が指定ページの反映を処理
//redirectは引数のURIに対して値を受け取る。引数には$this(トレイトを利用するRegisterController)にredirectPathは、
//トレイトがさらにRedirectsUsersというトレイトをuseしていて、そこに定義されたメソッドである
//public function redirectPath(){if (method_exists($this, 'redirectTo')) {return $this->redirectTo()}return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';}
//内容は、RegisterControllerにredirectToメソッドがあれば、そのプロパティの値を返す。
//定義なければ、$this->redirectTo : '/home'つまり、このページの38行目に定義されたプロパティーの存在に返り値を指定する。
