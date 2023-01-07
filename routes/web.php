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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', 'PageController@home')->name('home');
//Route::get('customers', 'PageController@customers')->name('customers');
Route::get('review-requests', 'PageController@invitesSent')->name('review-requests');
Route::get('email-view', 'PageController@emailTemplate')->name('email-view');

//Route::get('register', 'PageController@register')->name('register');
//Route::get('login', 'PageController@login')->name('login');
//Route::get('forgot-password', 'PageController@forgotPassword')->name('forgot-password');

//Route::get('company', 'PageController@company')->name('company');

// Route::get('billing', 'PageController@billing')->name('billing');

Route::get('payment', 'PageController@payment')->name('payment');

Route::get('review-widget', 'PageController@reviewWidget')->name('review-widget');
