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

Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');
});
/********************* system administrators ******************/

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'AdminController@showLoginView')->name('admin-login');
    Route::post('login', 'AdminController@login')->name('post-login');
    Route::get('logout', 'AdminController@logOut')->name('admin.logout');
});

Route::group(['middleware' => 'adminAllow', 'prefix' => 'admin'], function () {

    Route::get('dashboard', 'DashboardController@dashboard')->name('adminDashboard');

    Route::get('deleted-users', 'DashboardController@deletedUsers')->name('deletedUsers');

    Route::get('user/edit/{id?}', 'DashboardController@editUser')->name('userEdit');

    Route::put('update-user/{id}', 'DashboardController@updateUser')->name('update.user');

    /********************* system administrators users listing ******************/
});
