<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){ return view('welcome'); })->name('welcome');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){  

    Auth::routes([
        'register' => true,
        'reset'    => false,
        'verify'   => false
    ]);

    Route::middleware('auth:admin')->group(function () {
        Route::resource('home', 'HomeController', ['only' => 'index']);
        Route::get('/approval/index', 'ApprovalController@index')->name('approval.index');
        Route::get('/approval/show/{id}/{user}/{year}', 'ApprovalController@show')->name('approval.show');
        Route::post('/approval/store', 'ApprovalController@store')->name('approval.store');
        Route::get('pdf/{id}/{user}/{year}','PDFController@index')->name('pdf');
    });
});

Route::namespace('User')->prefix('user')->name('user.')->group(function(){
    
    Auth::routes([
        'register' => true,
        'reset'    => false,
        'verify'   => false
    ]);

    Route::middleware('auth:user')->group(function () {
       
        // TOPページ
        // Route:resource('/home', 'HomeController@index')->name('home.index');
        Route::resource('home', 'HomeController', ['only' => 'index']);
        Route::get('/shifts/index', 'ShiftController@index')->name('shifts.index');
        Route::post('/shifts/index/store', 'ShiftController@store_ajax')->name('shift.ajax');
        Route::post('/shifts/index/store/monthly', 'ShiftController@store_monthly')->name('shift.monthly');
        Route::get('/shifts/index/{dates}', 'ShiftController@switch')->name('shifts.switch');
        
});
});




// Route::namespace('User')->prefix('user')->name('user.')->group(function () {

//     // ログイン認証関連
//     Auth::routes([
//         'login' => true,
//         'register' => true,
//         'reset'    => true,
//         'verify'   => true
//     ]);

//     // ログイン認証後
//     Route::middleware('auth:user')->group(function () {

//         // TOPページ
//         Route::get('/shifts/index', 'ShiftController@index')->name('shifts.index');
//         Route::post('/shifts/index/store', 'ShiftController@store_ajax')->name('shift.ajax');
//         Route::post('/shifts/index/store/monthly', 'ShiftController@store_monthly')->name('shift.monthly');
//         Route::get('/shifts/index/{date}', 'ShiftController@switch')->name('shifts.switch');



//     });
// });


// Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
//Illuminate\Routing\Router.phpのroutes()メソッドでルーティングが表示される


// /にアクセス
// Route::get('/', function () { return redirect('/home'); });
//TOPページにアクセス（ユーザー認証がコントローラーに処理を飛ばす前にかかる）
// Route::group(['middleware' => 'auth:user'], function() {
//     Auth::routes();
//     Route::get('/home', 'HomeController@index')->name('home');
// });
//adminのルーティング
// Route::group(['prefix' => 'admin'], function() {
    //アクセス
//     Route::get('/', function () { return redirect('/admin/home'); });
//     Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
//     Route::post('login', 'Admin\LoginController@login');
// });

// Route::group(['middleware' => 'auth:user'], function(){
//     Route::get('/shifts/index', 'ShiftController@index')->name('shifts.index');
//     Route::post('/shifts/index/store', 'ShiftController@store_ajax')->name('shift.ajax');
//     Route::post('/shifts/index/store/monthly', 'ShiftController@store_monthly')->name('shift.monthly');
//     Route::get('/shifts/index/{date}', 'ShiftController@switch')->name('shifts.switch');


// });

