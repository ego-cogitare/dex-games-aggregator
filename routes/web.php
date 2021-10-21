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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login', 'AuthController@showLoginForm')->name('admin.login');
        Route::post('/login', 'AuthController@login')->name('admin.login.submit');
    });
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('/logout', function() {
            Auth::logout();
            return redirect()->intended(route('admin.login'));
        });
        Route::any('/', 'IndexController@history')->name('admin.default');
        Route::get('/history', 'IndexController@history');
        Route::get('/pending', 'IndexController@pending');
        Route::get('/staff', 'IndexController@staff');
        Route::get('/balances', 'IndexController@balances');
        Route::get('/account/{account}/atomichub', 'IndexController@atomichub');
        Route::get('/game/alienworlds', 'GameController@alienworlds');
    });
});