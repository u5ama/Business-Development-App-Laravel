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
Route::get('statTrackingReviewData', 'ReviewsController@statTrackingReviewData')->name('statTrackingReviewData');
Route::get('statTrackingRatingData', 'ReviewsController@statTrackingRatingData')->name('statTrackingRatingData');

Route::group(['middleware' => ['userAllow']], function () {
    Route::get('/', 'HomeController@home')->name('home');

    Route::get('reviews', 'ReviewsController@reviewsList')->name('reviews');

    Route::get('company-listings', 'BusinessController@businessListing')->name('citation-listings');
    Route::get('company-reviews', 'BusinessController@companyReviews')->name('company-reviews');

    Route::get('apps-connection', 'ReviewsController@thirdPartyAppsList')->name('apps-connection');

    
    Route::get('company', 'PageController@company')->name('company');
    Route::get('website-audit', 'PageController@websiteAudit')->name('websiteAudit');
    
});

Route::get('business-review/{email}/{secret}/{business}/{reviewID}/{flag?}', 'PageController@showBusinessReview');
Route::get('business-review-complete/{email}/{secret}/{business}', 'PageController@businessReviewComplete');

// Upgrade


Route::post('done-me', 'CommonController@ajaxRequestManager');

Route::prefix('business')->group(function () {
    Route::get('/', 'BusinessController@index');

    Route::post('social-selection-pages', 'SocialController@socialPageList');
    Route::post('remove-access-token', 'SocialController@removeAccessToken');
});
