<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth:admin']], function () {
	Route::get('dashboard/get_count', 'Admin\DashboardController@getCount')->name('dashboard.get_count');
});
	Route::post('/advertising-form/{comment?}', 'AdvertisingController@submitForm')->name('front.advertising.submit');
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::post('/baby_sitting-form/{comment?}', 'BabySittingController@submitForm')->name('front.babysitting.submit');
	Route::post('/blogcomment-form/{comment?}', 'BlogController@submitForm')->name('front.blog.comment.submit');
	Route::post('/videoscomment-form/{comment?}', 'VideosController@submitForm')->name('front.videos.comment.submit');

	Route::post('/desi-date-form/{comment?}', 'DesiDateController@submitForm')->name('front.desi_date.submit');
	Route::post('/temples-form/{comment?}', 'TemplesController@submitForm')->name('front.temples.comment.submit');
	Route::post('/pubs-form/{comment?}', 'PubsController@submitForm')->name('front.pubs.comment.submit');
	Route::post('/business-form/{comment?}', 'BusinessController@submitForm')->name('front.business.comment.submit');
	Route::post('/forum-form/{comment?}', 'ForumController@submitForm')->name('front.forum.comment.submit');
	Route::post('/grocieries-form/{comment?}', 'GrocieriesController@submitForm')->name('front.grocieries.submit');
	Route::post('/sports-form/{comment?}', 'SportsController@submitForm')->name('front.sports.submit');
	Route::post('/theaters-form/{comment?}', 'TheatersController@submitForm')->name('front.theaters.submit');
	Route::post('/subscribe-newsletter/{comment?}', 'SubscribeController@submitForm')->name('front.subscribe_newsletter.submit');
	Route::post('discussion-room-form/{comment?}', 'NrisTalkController@submitForm')->name('front.nris.submit');

	Route::get('/forum/threads/create_topic/{id}', 'ForumController@CreateForum')->name('front.forum.create');
	Route::post('/forum/threads/submit_topic', 'ForumController@SubmitForumData')->name('front.forum.submit');

	Route::get('/nricard-verifaction/{card_no}', 'ProfileController@verifaction')->name('front.nricard.verifaction');
	Route::post('/nricard-active', 'ProfileController@cardActive')->name('front.profile.card.active');

	Route::get('batches/create_ad/{id?}', 'NationalBeatchsController@createAd')->name('front.nationalbatch.create_ad');
	Route::post('batches-ad-sumbit/{id?}', 'NationalBeatchsController@sumbitAd')->name('front.nationalbatch.submit_ad');
	Route::get('batches-delete/create_ad/{id}', 'NationalBeatchsController@deleteAd')->name('front.nationalbatch.delete_ad');

	Route::any('add_carpool-form/{id?}', 'CarpoolController@createAd')->name('addcarpool.form');
	Route::any('add_carpool-submit_form/{id?}', 'CarpoolController@submitAd')->name('addcarpool.submit_form');

	Route::any('blog-from/{id?}', 'BlogController@createAd')->name('front.blog.from');
	Route::post('blog-submit_from/{id?}', 'BlogController@sumbitAd')->name('front.blog.SubmitFrom');
});

Route::group(['middleware' => ['web', 'auth', 'checkState']], function () {
	Route::get('/discussion-room/create_topic', 'NrisTalkController@createTopic')->name('front.nristalk.create');
	Route::post('/discussion-room-sumbit-topic', 'NrisTalkController@sumbitTopic')->name('front.nristalk.submit_topic');
	// add_type = create_free_add || create_premium_add || update_ad
	Route::get('/realestate/ad-delete/{id}', 'RealEstateController@deleteAd')->name('front.realestate.delete_ad');
	Route::get('/realestate/{add_type}/{id?}', 'RealEstateController@createAd')->name('front.realestate.create_ad');
	Route::post('/realestate-ad-sumbit/{add_type}/{id?}', 'RealEstateController@sumbitAd')->name('front.realestate.submit_ad');

	Route::get('/baby_sitting/ad-delete/{id?}', 'BabySittingController@deleteAd')->name('front.babysitting.delete_ad');
	Route::get('/baby_sitting/{add_type}/{id?}', 'BabySittingController@createAd')->name('front.babysitting.create_ad');
	Route::post('/baby_sitting-ad-sumbit/{add_type}/{id?}', 'BabySittingController@sumbitAd')->name('front.babysitting.submit_ad');

	Route::get('/education/ad-delete/{id}', 'EducationTeachingController@deleteAd')->name('front.education.delete_ad');
	Route::get('/education/{add_type}/{id?}', 'EducationTeachingController@createAd')->name('front.education.create_ad');
	Route::post('/education-ad-sumbit/{add_type}/{id?}', 'EducationTeachingController@sumbitAd')->name('front.education.submit_ad');

	Route::get('/electronics/ad-delete/{id}', 'ElectronicsController@deleteAd')->name('front.electronics.delete_ad');
	Route::get('/electronics/{add_type}/{id?}', 'ElectronicsController@createAd')->name('front.electronics.create_ad');
	Route::post('/electronics-ad-sumbit/{add_type}/{id?}', 'ElectronicsController@sumbitAd')->name('front.electronics.submit_ad');

	Route::get('/garagesale/ad-delete/{id}', 'GarageSaleController@deleteAd')->name('front.garagesale.delete_ad');
	Route::get('/garagesale/{add_type}/{id?}', 'GarageSaleController@createAd')->name('front.garagesale.create_ad');
	Route::post('/garagesale-ad-sumbit/{add_type}/{id?}', 'GarageSaleController@sumbitAd')->name('front.garagesale.submit_ad');

	Route::get('/job/ad-delete/{id}', 'JobController@deleteAd')->name('front.job.delete_ad');
	Route::get('/job/{add_type}/{id?}', 'JobController@createAd')->name('front.job.create_ad');
	Route::post('/job-ad-sumbit/{add_type}/{id?}', 'JobController@sumbitAd')->name('front.job.submit_ad');

	Route::get('/other/ad-delete/{id}', 'OtherController@deleteAd')->name('front.other.delete_ad');
	Route::get('/other/{add_type}/{id?}', 'OtherController@createAd')->name('front.other.create_ad');
	Route::post('/other-ad-sumbit/{add_type}/{id?}', 'OtherController@sumbitAd')->name('front.other.submit_ad');

	Route::get('/roommates/ad-delete/{id}', 'RoomMateController@deleteAd')->name('front.roommate.delete_ad');
	Route::get('/roommates/{add_type}/{id?}', 'RoomMateController@createAd')->name('front.roommate.create_ad');
	Route::post('/roommates-ad-sumbit/{add_type}/{id?}', 'RoomMateController@sumbitAd')->name('front.roommate.submit_ad');

	Route::get('/desi-date/ad-delete/{id}', 'DesiDateController@deleteAd')->name('front.desidate.delete_ad');
	Route::get('/desi-date/{add_type}/{id?}', 'DesiDateController@createAd')->name('front.desidate.create_ad');
	Route::post('/desi-date-ad-sumbit/{add_type}/{id?}', 'DesiDateController@sumbitAd')->name('front.desidate.submit_ad');

	Route::get('/freestuff/ad-delete/{id}', 'FreeStuffController@deleteAd')->name('front.freestuff.delete_ad');
	Route::get('/free_stuff/{add_type}/{id?}', 'FreeStuffController@createAd')->name('front.freestuff.create_ad');
	Route::post('/freestuff-ad-sumbit/{add_type}/{id?}', 'FreeStuffController@sumbitAd')->name('front.freestuff.submit_ad');

	Route::get('/national-autos/ad-delete/{id}', 'AutoController@deleteAd')->name('front.national_autos.delete_ad');
	Route::get('/national-autos/{add_type}/{id?}', 'AutoController@createAd')->name('front.national_autos.create_ad');
	Route::post('/national-autos-ad-sumbit/{add_type}/{id?}', 'AutoController@sumbitAd')->name('front.national_autos.submit_ad');

	//Route::get('students_talk/add_university', 'AddUniversityController@index')->name('adduniversity.index');
	//Route::get('students_talk/{id}', 'AddUniversityController@view')->name('adduniversity.view');
	Route::get('students_talk-topic_list/{topic}/{uni}', 'AddUniversityController@topic_list')->name('topic.list');
	Route::get('add_university-form', 'AddUniversityController@indexForm')->name('adduniversity.form');
	Route::get('add_university-Topic', 'AddUniversityController@Topic_Form')->name('adduniversity.topic_form');
	Route::any('add_university-submit_Topic', 'AddUniversityController@submitTopic')->name('adduniversity.submit_topic');
	Route::post('add_university-submit_form', 'AddUniversityController@submitForm')->name('adduniversity.submit_form');

});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home/search', 'HomeController@search')->name('home.search');
Route::post('recent', 'HomeController@recent')->name('home.recent');
Route::post('nristalk', 'HomeController@nristalk')->name('home.nristalk');
Route::post('dmoviesandnational', 'HomeController@dmoviesandnational')->name('home.dmoviesandnational');
Route::post('vistingsports', 'HomeController@vistingsports')->name('home.vistingsports');
Route::post('gifdata', 'HomeController@gifdata')->name('home.gifdata');

Route::get('/blog', 'BlogController@index')->name('front.blog');
Route::get('/blog/{id}', 'BlogController@view')->name('front.blog.view');
Route::get('/video/{id}', 'VideosController@view')->name('front.video.view');

Route::get('/videos/category/{videos_languages}/{category?}', 'VideosController@index')->name('front.videos.category');
Route::get('/videos/{videos_languages?}/', 'VideosController@index')->name('front.videos');

Route::get('/aboutus', 'AboutUsController@index')->name('front.aboutus');

Route::get('/terms_conditions', 'TermsConditionController@index')->name('front.termscondition');

Route::get('/privacy', 'PrivacyController@index')->name('front.privacy');

Route::get('/disclaimer', 'DisclaimerController@index')->name('front.disclaimer');

Route::get('/advertising', 'AdvertisingController@index')->name('front.advertising');

Route::get('/contact-us', 'ContactUsController@index')->name('front.contact_us');

Route::get('/desi_meet/{category?}', 'DesiDateController@index')->name('front.desi_date');
Route::get('/desi-meet/{slug}', 'DesiDateController@view')->name('front.desi_date.view');

Route::get('/temples/{slug?}', 'TemplesController@index')->name('front.temples');
Route::get('/temple/{slug}', 'TemplesController@view')->name('front.temples.view');

Route::get('/pubs/{slug?}', 'PubsController@index')->name('front.pubs');
Route::get('/pub/{slug}', 'PubsController@view')->name('front.pubs.view');

Route::get('/business/{slug?}', 'BusinessController@index')->name('front.business');
Route::get('/business-view/{slug}', 'BusinessController@view')->name('front.business.view');

Route::get('/carpool/{slug}', 'CarpoolController@index')->name('front.carpool');

Route::get('/news-videos/{slug}', 'NewsVideoController@view')->name('front.newsvideo.view');

Route::get('/forum-view/{slug}', 'ForumController@view')->name('front.forum.view');
Route::get('/forum/threads_search/', 'ForumController@ThreadSearch')->name('front.forum.thread_search');

Route::get('/movie-reviews', 'MovieReviewController@index')->name('front.moviereview.list');

Route::get('/baby-sitting/{slug?}', 'BabySittingController@index')->name('front.babysitting.list');
Route::get('/baby-sitting-view/{slug}', 'BabySittingController@view')->name('front.babysitting.view');

Route::get('/grocieries/{slug?}', 'GrocieriesController@index')->name('front.grocieries.list');
Route::get('/grocieries-view/{slug}', 'GrocieriesController@view')->name('front.grocieries.view');

Route::get('/sports', 'SportsController@index')->name('front.sports.list');
Route::get('/sports-view/{slug}', 'SportsController@view')->name('front.sports.view');

Route::get('/theaters/{slug?}', 'TheatersController@index')->name('front.theaters.list');
Route::get('/theaters-view/{slug}', 'TheatersController@view')->name('front.theaters.view');

Route::get('/city/autocomplete/{slug?}', 'CityController@AutoComplete')->name('city.autocomplete');
Route::get('/city/autodropdown/{slug?}', 'CityController@autodropdown')->name('city.autodropdown');

Route::post('/setCountry', 'CommonController@setCountry')->name('front.setCountry');

Route::get('/discussion-room', 'NrisTalkController@index')->name('front.nris');
Route::get('/discussion-room-view/{slug?}', 'NrisTalkController@view')->name('front.nris.view');

Route::post('/setState', 'HomeController@setStateAdd')->name('front.setStateAdd');
Route::get('/getCreateAdUrl/{slug?}/{slug1?}/{slug2?}', 'HomeController@getCreateAdUrl')->name('front.getCreateAdUrl');

Route::post("send-email", 'MailerController@composeEmail')->name("send-email");

Route::post('/auth-forgotpassword', 'AuthController@forgotPassword')->name('front.forgotpassword');
Route::post('/auth-password/reset-submit', 'AuthController@resetPassword')->name('front.password_reset_submit');
Route::get('students_talk/{id}', 'AddUniversityController@view')->name('adduniversity.view');
Route::get('students_talk/add_university', 'AddUniversityController@index')->name('adduniversity.index');
