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

Route::group(['middleware' => 'guestAllow'], function () {
    Route::get('register', 'UserController@create')->name('register');
    Route::post('register', 'UserController@store')->name('user.register');

    Route::get('login', 'UserController@showLogin')->name('login');
    Route::post('login', 'UserController@login')->name('user.login');

    Route::get('forgot-password', 'UserController@showForgotPasswordPage')->name('forgot-password');
});


Route::get('logout', 'UserController@logOut')->name('user.logout');
Route::group(['middleware' => ['userAllow']], function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('upgrade', 'PlanController@upgrade')->name('upgrade');
    Route::get('billing', 'PlanController@billing')->name('billing');
});


