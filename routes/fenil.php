<?php

use Illuminate\Support\Facades\Route;
Route::any('nris-card-notify_url', 'MembershipController@fun_notify_url')->name('cardbuy.notify_url');
Route::any('premium-ads-notify_url/{id}/{model}', 'PremiumAdsController@fun_notify_url')->name('adsbuy.notify_url');

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::post('educationteaching-form/{comment?}', 'EducationTeachingController@submitForm')->name('educationteaching.submit');
	Route::post('event-form/{comment?}', 'NationalEventController@submitForm')->name('event.submit');
	Route::post('/nationalbeatch-form/{comment?}', 'NationalBeatchsController@submitForm')->name('nationalbeatch.submit');
	Route::post('/studenttalk-sumbit/{comment?}', 'StudentTalkController@submitForm')->name('front.studenttalk.submit');
	Route::post('realestate-form/{comment?}', 'RealEstateController@submitForm')->name('realestate.submit');
	Route::post('auto-form/{comment?}', 'AutoController@submitForm')->name('auto.submit');
	Route::post('autobio-form', 'AutoController@submitBio')->name('auto.submitbio');
	Route::post('electronics-form/{comment?}', 'ElectronicsController@submitForm')->name('electronics.submit');
	Route::post('freestuff-form/{comment?}', 'FreeStuffController@submitForm')->name('freestuff.submit');
	Route::post('garagesale-form/{comment?}', 'GarageSaleController@submitForm')->name('garagesale.submit');
	Route::post('room-form/{comment?}', 'RoomMateController@submitForm')->name('room_mate.submit');
	Route::post('room-bioform', 'RoomMateController@submitBio')->name('room_mate.submitbio');
	Route::post('restaurants-form{comment?}', 'RestaurantsController@submitForm')->name('restaurants.submit');
	Route::post('casinos-form/{comment?}', 'CasinosController@submitForm')->name('casinos.submit');
	Route::post('desipage-form/{comment?}', 'DesiPageController@submitForm')->name('desi_page.submit');
	Route::get('nris-card', 'MembershipController@index')->name('membership.index');
	Route::post('desi-movie-form/{comment?}', 'DesiMoviesController@submitForm')->name('desi_movie.submit');

	// --------- NRIS Card ---------
	Route::any('nris-card-payment', 'MembershipController@payment')->name('membership.pay');
	Route::any('nris-card-return', 'MembershipController@fun_return')->name('cardbuy.return');
	Route::any('nris-card-cancel_return', 'MembershipController@fun_cancel_return')->name('cardbuy.cancel_return');
	Route::any('nris-card-startpayment/{card_type}', 'MembershipController@startPayment')->name('cardbuy.startPayment');

	// ------- Premium Ad ---------
	Route::any('premium-ads-payment', 'PremiumAdsController@payment')->name('ads_purches.pay');
	Route::any('premium-ads-return', 'PremiumAdsController@fun_return')->name('preadbuy.return');
	Route::any('premium-ads-cancel_return', 'PremiumAdsController@fun_cancel_return')->name('preadbuy.cancel_return');
	Route::any('premium-ads-startpayment/{ad_id}/{model}', 'PremiumAdsController@startPayment')->name('preadbuy.startPayment');

	// --------- ADS Bid Submit ---------
	Route::any('ads-bid-submit', 'AdsBidController@from_bid_ads')->name('ads_bid.submit');

});

Route::any('desi_movies', 'DesiMoviesController@index')->name('desi_movies.index');
Route::any('desi_movies-view/{slug}', 'DesiMoviesController@getdata')->name('desi_movies.view');

Route::get('national-real-estate/{slug?}', 'RealEstateController@index')->name('realestate.index');
Route::get('real-estate/{slug}', 'RealEstateController@getdata')->name('realestate.view');

Route::get('education-teaching/{slug?}', 'EducationTeachingController@index')->name('educationteaching.index');
Route::get('education-teaching-view/{slug}', 'EducationTeachingController@getdata')->name('educationteaching.view');

Route::get('national-autos', 'AutoController@index')->name('auto.index');
Route::get('national-autos-view/{slug}', 'AutoController@getdata')->name('auto.view');

Route::get('casinos/{slug?}', 'CasinosController@index')->name('casinos.index');
Route::get('casino/{slug}', 'CasinosController@getdata')->name('casinos.view');

Route::get('restaurants/{slug?}', 'RestaurantsController@index')->name('restaurants.index');
Route::get('restaurant/{slug}', 'RestaurantsController@getdata')->name('restaurants.view');

Route::get('jobs/{cat_name?}', 'JobController@index')->name('job.index');
Route::get('career/{slug}', 'JobController@getdata')->name('job.view');
Route::post('job-form/{comment?}', 'JobController@submitForm')->name('job.submit');

Route::get('/studenttalk-view/{slug}', 'StudentTalkController@view')->name('studenttalk.view');

Route::get('batches/category_ad/{id?}', 'NationalBeatchsController@index')->name('nationalbatch.index');
Route::get('/batches-view/{slug}', 'NationalBeatchsController@view')->name('nationalbatch.view');

Route::get('room-mates/{slug?}', 'RoomMateController@index')->name('room_mate.index');
Route::get('roommates-view/{slug}', 'RoomMateController@getdata')->name('room_mate.view');

Route::get('electronics/{slug?}', 'ElectronicsController@index')->name('electronics.index');
Route::get('electronics-view/{slug}', 'ElectronicsController@getdata')->name('electronics.view');

Route::get('garage-sale/{slug?}', 'GarageSaleController@index')->name('garagesale.index');
Route::get('garage-sale-view/{slug}', 'GarageSaleController@getdata')->name('garagesale.view');

Route::get('free-stuff/{slug?}', 'FreeStuffController@index')->name('freestuff.index');
Route::get('free_stuff-view/{slug}', 'FreeStuffController@getdata')->name('freestuff.view');

Route::get('other', 'OtherController@index')->name('other.index');
Route::get('other-view/{slug}', 'OtherController@getdata')->name('other.view');
Route::post('other-form/{comment?}', 'OtherController@submitForm')->name('other.submit');

Route::get('national-events/category-ad/{id}', 'NationalEventController@index')->name('event.index');
Route::get('national-events/{slug}', 'NationalEventController@getdata')->name('event.view');

Route::get('desi-page', 'DesiPageController@index')->name('desi_page.index');
Route::get('desipage-view/{slug}', 'DesiPageController@view')->name('desi_page.view');

// Route::post('get-states-by-country','CountryStateCityController@getState');
Route::any('verifyemail/{id}', 'AuthController@mailverification');