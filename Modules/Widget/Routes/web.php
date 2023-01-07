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


Route::group(['middleware' => ['userAllow']], function () {
  
    Route::get('widgets', 'WidgetController@widgets')->name('widgets');

    // Route::get('/widget', 'WidgetController@widgetList')->name('widget');

    Route::get('create-widget', 'WidgetController@createWidget')->name('createWidget');

    Route::post('createNewWidget', 'WidgetController@createNewWidget')->name('createNewWidget');
    Route::post('widgetSetting', 'WidgetController@widgetSetting')->name('widgetSetting');
    Route::post('widgetTheme', 'WidgetController@widgetTheme')->name('widgetTheme');


    // queries
    Route::get('numberOfReviews', 'WidgetController@numberOfReviews')->name('numberOfReviews');
    
    Route::get('widgetsList', 'WidgetController@widgetsList')->name('widgetsList');

    // Route::get('showWidget', 'WidgetController@showWidget')->name('showWidget');
    Route::get('showWidgetView', 'WidgetController@showWidgetView')->name('showWidgetView');

    Route::get('delete-widget', 'WidgetController@deleteWidget')->name('delete-widget');

});
