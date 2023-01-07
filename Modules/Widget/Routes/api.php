<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/widget', function (Request $request) {
    return $request->user();
});

// Route::get('/widgetapi', function () {
//     return 'abc';
// });
Route::group(['middleware' => ['cors']], function(){
    Route::get('showWidget', 'WidgetController@showWidget')->name('showWidget');
});

// Route::get('test', 'WidgetController@showWidget')->name('test');
