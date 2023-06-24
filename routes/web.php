<?php

use Illuminate\Support\Facades\Route;

Route::get('admin', 'Admin\AuthController@index')->name('admin.login');
Route::get('admin/logout', 'Admin\AuthController@logout')->name('admin.logout');
Route::post('admin', 'Admin\AuthController@submitForm')->name('admin.login_submit');

Route::prefix('admin')->group(function () {
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.reset.submit');
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth:admin']], function () {
	Route::get('get-city', 'Admin\CityController@getByState')->name('get_city');
	Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
	Route::get('change-state/{id}', 'Admin\DashboardController@changeState')->name('change_state');

	Route::get('state', 'Admin\StateController@index')->name('state.index');
	Route::get('state-form/{id?}', 'Admin\StateController@getForm')->name('state.form');
	Route::post('state-form/{id?}', 'Admin\StateController@submitForm')->name('state.submit');
	Route::any('state-delete', 'Admin\StateController@deleteItem')->name('state.delete');

	Route::get('city', 'Admin\CityController@index')->name('city.index');
	Route::get('city-form/{id?}', 'Admin\CityController@getForm')->name('city.form');
	Route::post('city-form/{id?}', 'Admin\CityController@submitForm')->name('city.submit');
	Route::any('city-delete', 'Admin\CityController@deleteItem')->name('city.delete');

	Route::get('country', 'Admin\CountryController@index')->name('country.index');
	Route::get('country-form/{id?}', 'Admin\CountryController@getForm')->name('country.form');
	Route::post('country-form/{id?}', 'Admin\CountryController@submitForm')->name('country.submit');
	Route::any('country-delete', 'Admin\CountryController@deleteItem')->name('country.delete');

	Route::get('famous-temples', 'Admin\FamousTemplesController@index')->name('famous_temples.index');
	Route::get('famous-temples-form/{id?}', 'Admin\FamousTemplesController@getForm')->name('famous_temples.form');
	Route::post('famous-temples-form/{id?}', 'Admin\FamousTemplesController@submitForm')->name('famous_temples.submit');
	Route::get('famous-temples-delete/{id}', 'Admin\FamousTemplesController@deleteItem')->name('famous_temples.delete');

	Route::get('famous-restaurant', 'Admin\FamousRestaurantController@index')->name('famous_restaurant.index');
	Route::get('famous-restaurant-form/{id?}', 'Admin\FamousRestaurantController@getForm')->name('famous_restaurant.form');
	Route::post('famous-restaurant-form/{id?}', 'Admin\FamousRestaurantController@submitForm')->name('famous_restaurant.submit');
	Route::get('famous-restaurant-delete/{id}', 'Admin\FamousRestaurantController@deleteItem')->name('famous_restaurant.delete');

	Route::get('famous-grocery', 'Admin\FamousGroceryController@index')->name('famous_grocery.index');
	Route::get('famous-grocery-form/{id?}', 'Admin\FamousGroceryController@getForm')->name('famous_grocery.form');
	Route::post('famous-grocery-form/{id?}', 'Admin\FamousGroceryController@submitForm')->name('famous_grocery.submit');
	Route::get('famous-grocery-delete/{id}', 'Admin\FamousGroceryController@deleteItem')->name('famous_grocery.delete');

	Route::get('video/category', 'Admin\VideoCategoryController@index')->name('video_category.index');
	Route::get('video/category-form/{id?}', 'Admin\VideoCategoryController@getForm')->name('video_category.form');
	Route::post('video/category-form/{id?}', 'Admin\VideoCategoryController@submitForm')->name('video_category.submit');
	Route::get('video/category-delete/{id}', 'Admin\VideoCategoryController@deleteItem')->name('video_category.delete');

	Route::get('video/language', 'Admin\VideoLanguageController@index')->name('video_language.index');
	Route::get('video/language-form/{id?}', 'Admin\VideoLanguageController@getForm')->name('video_language.form');
	Route::post('video/language-form/{id?}', 'Admin\VideoLanguageController@submitForm')->name('video_language.submit');
	Route::get('video/language-delete/{id}', 'Admin\VideoLanguageController@deleteItem')->name('video_language.delete');

	Route::get('famous-sport', 'Admin\FamousSportController@index')->name('famous_sports.index');
	Route::get('famous-sport-form/{id?}', 'Admin\FamousSportController@getForm')->name('famous_sports.form');
	Route::post('famous-sport-form/{id?}', 'Admin\FamousSportController@submitForm')->name('famous_sports.submit');
	Route::get('famous-sport-delete/{id}', 'Admin\FamousSportController@deleteItem')->name('famous_sports.delete');

	Route::get('famous-pub', 'Admin\FamousPubController@index')->name('famous_pubs.index');
	Route::get('famous-pub-form/{id?}', 'Admin\FamousPubController@getForm')->name('famous_pubs.form');
	Route::post('famous-pub-form/{id?}', 'Admin\FamousPubController@submitForm')->name('famous_pubs.submit');
	Route::get('famous-pub-delete/{id}', 'Admin\FamousPubController@deleteItem')->name('famous_pubs.delete');

	Route::get('famous-casino', 'Admin\FamousCasinoController@index')->name('famous_casinos.index');
	Route::get('famous-casino-form/{id?}', 'Admin\FamousCasinoController@getForm')->name('famous_casino.form');
	Route::post('famous-casino-form/{id?}', 'Admin\FamousCasinoController@submitForm')->name('famous_casino.submit');
	Route::get('famous-casino-delete/{id}', 'Admin\FamousCasinoController@deleteItem')->name('famous_casino.delete');

	Route::get('famous-theater', 'Admin\FamousTheaterController@index')->name('famous_theaters.index');
	Route::get('famous-theater-form/{id?}', 'Admin\FamousTheaterController@getForm')->name('famous_theaters.form');
	Route::post('famous-theater-form/{id?}', 'Admin\FamousTheaterController@submitForm')->name('famous_theaters.submit');
	Route::get('famous-theater-delete/{id}', 'Admin\FamousTheaterController@deleteItem')->name('famous_theaters.delete');

	Route::get('famous-advertisement', 'Admin\FamousAdvertisementController@index')->name('famous_advertisements.index');
	Route::get('famous-advertisement-form/{id?}', 'Admin\FamousAdvertisementController@getForm')->name('famous_advertisements.form');
	Route::post('famous-advertisement-form/{id?}', 'Admin\FamousAdvertisementController@submitForm')->name('famous_advertisements.submit');
	Route::get('famous-advertisement-delete/{id}', 'Admin\FamousAdvertisementController@deleteItem')->name('famous_advertisements.delete');

	Route::get('famous-event', 'Admin\FamousEventController@index')->name('famous_event.index');
	Route::get('famous-event-form/{id?}', 'Admin\FamousEventController@getForm')->name('famous_event.form');
	Route::post('famous-event-form/{id?}', 'Admin\FamousEventController@submitForm')->name('famous_event.submit');
	Route::get('famous-event-delete/{id}', 'Admin\FamousEventController@deleteItem')->name('famous_event.delete');

	Route::get('famous-batche', 'Admin\FamousBatcheController@index')->name('famous_batche.index');
	Route::get('famous-batche-form/{id?}', 'Admin\FamousBatcheController@getForm')->name('famous_batche.form');
	Route::post('famous-batche-form/{id?}', 'Admin\FamousBatcheController@submitForm')->name('famous_batche.submit');
	Route::get('famous-batche-delete/{id}', 'Admin\FamousBatcheController@deleteItem')->name('famous_batche.delete');

	Route::get('famous-studenttal', 'Admin\FamousStudenttalkController@index')->name('famous_studenttal.index');
	Route::get('famous-studenttal-form/{id?}', 'Admin\FamousStudenttalkController@getForm')->name('famous_studenttal.form');
	Route::post('famous-studenttal-form/{id?}', 'Admin\FamousStudenttalkController@submitForm')->name('famous_studenttal.submit');
	Route::get('famous-studenttal-delete/{id}', 'Admin\FamousStudenttalkController@deleteItem')->name('famous_studenttal.delete');

	Route::get('famous-citymovie', 'Admin\FamousCitymovieController@index')->name('famous_citymovie.index');
	Route::get('famous-citymovie-form/{id?}', 'Admin\FamousCitymovieController@getForm')->name('famous_citymovie.form');
	Route::post('famous-citymovie-form/{id?}', 'Admin\FamousCitymovieController@submitForm')->name('famous_citymovie.submit');
	Route::get('famous-citymovie-delete/{id}', 'Admin\FamousCitymovieController@deleteItem')->name('famous_citymovie.delete');

	Route::get('famous-desipage', 'Admin\FamousDesipageController@index')->name('famous_desipage.index');
	Route::get('famous-desipage-form/{id?}', 'Admin\FamousDesipageController@getForm')->name('famous_desipage.form');
	Route::post('famous-desipage-form/{id?}', 'Admin\FamousDesipageController@submitForm')->name('famous_desipage.submit');
	Route::get('famous-desipage-delete/{id}', 'Admin\FamousDesipageController@deleteItem')->name('famous_desipage.delete');

	Route::get('videos/', 'Admin\VideoController@index')->name('video.index');
	Route::get('videos-form/{id?}', 'Admin\VideoController@getForm')->name('video.form');
	Route::post('videos-form/{id?}', 'Admin\VideoController@submitForm')->name('video.submit');
	Route::get('videos-delete/{id}', 'Admin\VideoController@deleteItem')->name('video.delete');

	Route::get('blog/category', 'Admin\BlogCategoryController@index')->name('blog_category.index');
	Route::get('blog/category-form/{id?}', 'Admin\BlogCategoryController@getForm')->name('blog_category.form');
	Route::post('blog/category-form/{id?}', 'Admin\BlogCategoryController@submitForm')->name('blog_category.submit');
	Route::get('blog/category-delete/{id}', 'Admin\BlogCategoryController@deleteItem')->name('blog_category.delete');

	Route::get('blogs', 'Admin\BlogController@index')->name('blog.index');
	Route::get('blogs-form/{id?}', 'Admin\BlogController@getForm')->name('blog.form');
	Route::post('blogs-form/{id?}', 'Admin\BlogController@submitForm')->name('blog.submit');
	Route::get('blogs-delete/{id}', 'Admin\BlogController@deleteItem')->name('blog.delete');

	Route::get('automake', 'Admin\AutoMakeController@index')->name('automake.index');
	Route::get('automake-form/{id?}', 'Admin\AutoMakeController@getForm')->name('automake.form');
	Route::post('automake-form/{id?}', 'Admin\AutoMakeController@submitForm')->name('automake.submit');
	Route::get('automake-delete/{id}', 'Admin\AutoMakeController@deleteItem')->name('automake.delete');

	Route::get('automodel', 'Admin\AutoModelController@index')->name('automodel.index');
	Route::get('automodel-form/{id?}', 'Admin\AutoModelController@getForm')->name('automodel.form');
	Route::post('automodel-form/{id?}', 'Admin\AutoModelController@submitForm')->name('automodel.submit');
	Route::get('automodel-delete/{id}', 'Admin\AutoModelController@deleteItem')->name('automodel.delete');

	Route::get('autocolor', 'Admin\AutoColorController@index')->name('autocolor.index');
	Route::get('autocolor-form/{id?}', 'Admin\AutoColorController@getForm')->name('autocolor.form');
	Route::post('autocolor-form/{id?}', 'Admin\AutoColorController@submitForm')->name('autocolor.submit');
	Route::get('autocolor-delete/{id}', 'Admin\AutoColorController@deleteItem')->name('autocolor.delete');

	Route::get('baby-sitting-category', 'Admin\BabySittingCategoryController@index')->name('baby_sitting_category.index');
	Route::get('baby-sitting-category-form/{id?}', 'Admin\BabySittingCategoryController@getForm')->name('baby_sitting_category.form');
	Route::post('baby-sitting-category-form/{id?}', 'Admin\BabySittingCategoryController@submitForm')->name('baby_sitting_category.submit');
	Route::get('baby-sitting-category-delete/{id}', 'Admin\BabySittingCategoryController@deleteItem')->name('baby_sitting_category.delete');

	Route::get('education-teaching-category', 'Admin\EducationTeachingCategoryController@index')->name('education_teaching_category.index');
	Route::get('education-teaching-category-form/{id?}', 'Admin\EducationTeachingCategoryController@getForm')->name('education_teaching_category.form');
	Route::post('education-teaching-category-form/{id?}', 'Admin\EducationTeachingCategoryController@submitForm')->name('education_teaching_category.submit');
	Route::get('education-teaching-category-delete/{id}', 'Admin\EducationTeachingCategoryController@deleteItem')->name('education_teaching_category.delete');

	Route::get('electronics-category', 'Admin\ElectronicCategoryController@index')->name('electronic_category.index');
	Route::get('electronics-category-form/{id?}', 'Admin\ElectronicCategoryController@getForm')->name('electronic_category.form');
	Route::post('electronics-category-form/{id?}', 'Admin\ElectronicCategoryController@submitForm')->name('electronic_category.submit');
	Route::get('electronics-category-delete/{id}', 'Admin\ElectronicCategoryController@deleteItem')->name('electronic_category.delete');

	Route::get('job-category', 'Admin\JobCategoryController@index')->name('job_category.index');
	Route::get('job-category-form/{id?}', 'Admin\JobCategoryController@getForm')->name('job_category.form');
	Route::post('job-category-form/{id?}', 'Admin\JobCategoryController@submitForm')->name('job_category.submit');
	Route::get('job-category-delete/{id}', 'Admin\JobCategoryController@deleteItem')->name('job_category.delete');

	Route::get('theaters_type', 'Admin\TheaterTypeController@index')->name('theaters_type.index');
	Route::get('theaters_type-form/{id?}', 'Admin\TheaterTypeController@getForm')->name('theaters_type.form');
	Route::post('theaters_type-form/{id?}', 'Admin\TheaterTypeController@submitForm')->name('theaters_type.submit');
	Route::get('theaters_type-delete/{id}', 'Admin\TheaterTypeController@deleteItem')->name('theaters_type.delete');

	Route::get('my-partner-category', 'Admin\MyPartnerCategoryController@index')->name('mypartner_category.index');
	Route::get('my-partner-category-form/{id?}', 'Admin\MyPartnerCategoryController@getForm')->name('mypartner_category.form');
	Route::post('my-partner-category-form/{id?}', 'Admin\MyPartnerCategoryController@submitForm')->name('mypartner_category.submit');
	Route::get('my-partner-category-delete/{id}', 'Admin\MyPartnerCategoryController@deleteItem')->name('mypartner_category.delete');

	Route::get('my-partner-classified', 'Admin\MyPartnerController@index')->name('mypartner_classifieds.index');
	Route::post('my-partner-classified-change-type', 'Admin\MyPartnerController@changeType')->name('mypartner_classifieds.change_type');
	Route::get('my-partner-classified/{id}', 'Admin\MyPartnerController@viewItem')->name('mypartner_classifieds.view');
	Route::get('my-partner-classified-delete/{id}', 'Admin\MyPartnerController@deleteItem')->name('mypartner_classifieds.delete');

	Route::get('realestate-category', 'Admin\RealestateCategoryController@index')->name('realestate_category.index');
	Route::get('realestate-category-form/{id?}', 'Admin\RealestateCategoryController@getForm')->name('realestate_category.form');
	Route::post('realestate-category-form/{id?}', 'Admin\RealestateCategoryController@submitForm')->name('realestate_category.submit');
	Route::get('realestate-category-delete/{id}', 'Admin\RealestateCategoryController@deleteItem')->name('realestate_category.delete');

	Route::get('roommate-classified', 'Admin\RoomMateController@index')->name('roommate_classifieds.index');
	Route::post('roommate-classified-change-type', 'Admin\RoomMateController@changeType')->name('roommate_classifieds.change_type');
	Route::get('roommate-classified/{id}', 'Admin\RoomMateController@viewItem')->name('roommate_classifieds.view');
	Route::get('roommate-classified-delete/{id}', 'Admin\RoomMateController@deleteItem')->name('roommate_classifieds.delete');

	Route::get('garagesale-classified', 'Admin\GarageSaleController@index')->name('garagesale_classifieds.index');
	Route::post('garagesale-classified-change-type', 'Admin\GarageSaleController@changeType')->name('garagesale_classifieds.change_type');
	Route::get('garagesale-classified/{id}', 'Admin\GarageSaleController@viewItem')->name('garagesale_classifieds.view');
	Route::get('garagesale-classified-delete/{id}', 'Admin\GarageSaleController@deleteItem')->name('garagesale_classifieds.delete');

	Route::get('freestuff-classified', 'Admin\FreeStuffController@index')->name('freestuff_classifieds.index');
	Route::post('freestuff-classified-change-type', 'Admin\FreeStuffController@changeType')->name('freestuff_classifieds.change_type');
	Route::get('freestuff-classified/{id}', 'Admin\FreeStuffController@viewItem')->name('freestuff_classifieds.view');
	Route::get('freestuff-classified-delete/{id}', 'Admin\FreeStuffController@deleteItem')->name('freestuff_classifieds.delete');

	Route::get('other-classified', 'Admin\OtherController@index')->name('other_classifieds.index');
	Route::post('other-classified-change-type', 'Admin\OtherController@changeType')->name('other_classifieds.change_type');
	Route::get('other-classified/{id}', 'Admin\OtherController@viewItem')->name('other_classifieds.view');
	Route::get('other-classified-delete/{id}', 'Admin\OtherController@deleteItem')->name('other_classifieds.delete');

	Route::get('advertisement-classified', 'Admin\AdvertisementController@index')->name('advertisement_classified.index');
	Route::post('advertisement-classified-change-type', 'Admin\AdvertisementController@changeType')->name('advertisement_classified.change_type');
	Route::get('advertisement-classified/{id}', 'Admin\AdvertisementController@viewItem')->name('advertisement_classified.view');
	Route::get('advertisement-classified-delete/{id}', 'Admin\AdvertisementController@deleteItem')->name('advertisement_classified.delete');

	Route::get('room-mate-category', 'Admin\RoomMateCategoryController@index')->name('room_mate_category.index');
	Route::get('room-mate-category-form/{id?}', 'Admin\RoomMateCategoryController@getForm')->name('room_mate_category.form');
	Route::post('room-mate-category-form/{id?}', 'Admin\RoomMateCategoryController@submitForm')->name('room_mate_category.submit');
	Route::get('room-mate-category-delete/{id}', 'Admin\RoomMateCategoryController@deleteItem')->name('room_mate_category.delete');

	Route::get('garagesale-category', 'Admin\GaragesaleCategoryController@index')->name('garagesale_category.index');
	Route::get('garagesale-category-form/{id?}', 'Admin\GaragesaleCategoryController@getForm')->name('garagesale_category.form');
	Route::post('garagesale-category-form/{id?}', 'Admin\GaragesaleCategoryController@submitForm')->name('garagesale_category.submit');
	Route::get('garagesale-category-delete/{id}', 'Admin\GaragesaleCategoryController@deleteItem')->name('garagesale_category.delete');

	Route::get('auto-classified', 'Admin\AutoClassifiedController@index')->name('auto_classified.index');
	Route::post('auto-classified-change-type', 'Admin\AutoClassifiedController@changeType')->name('auto_classified.change_type');
	Route::get('auto-classified/{id}', 'Admin\AutoClassifiedController@viewItem')->name('auto_classified.view');
	Route::get('auto-classified-delete/{id}', 'Admin\AutoClassifiedController@deleteItem')->name('auto_classified.delete');

	Route::get('babysitting-classified', 'Admin\BabysittingClassifiedsController@index')->name('babysitting_classified.index');
	Route::post('babysitting-classified-change-type', 'Admin\BabysittingClassifiedsController@changeType')->name('babysitting_classified.change_type');
	Route::get('babysitting-classified/{id}', 'Admin\BabysittingClassifiedsController@viewItem')->name('babysitting_classified.view');
	Route::get('babysitting-classified-delete/{id}', 'Admin\BabysittingClassifiedsController@deleteItem')->name('babysitting_classified.delete');

	Route::get('educationteaching-classified', 'Admin\EducationTeachingClassifiedsController@index')->name('educationteaching_classified.index');
	Route::post('educationteaching-classified-change-type', 'Admin\EducationTeachingClassifiedsController@changeType')->name('educationteaching_classified.change_type');
	Route::get('educationteaching-classified/{id}', 'Admin\EducationTeachingClassifiedsController@viewItem')->name('educationteaching_classified.view');
	Route::get('educationteaching-classified-delete/{id}', 'Admin\EducationTeachingClassifiedsController@deleteItem')->name('educationteaching_classified.delete');

	Route::get('electronics-classified', 'Admin\ElectronicsClassifiedsController@index')->name('electronics_classifieds.index');
	Route::post('electronics-classified-change-type', 'Admin\ElectronicsClassifiedsController@changeType')->name('electronics_classifieds.change_type');
	Route::get('electronics-classified/{id}', 'Admin\ElectronicsClassifiedsController@viewItem')->name('electronics_classifieds.view');
	Route::get('electronics-classified-delete/{id}', 'Admin\ElectronicsClassifiedsController@deleteItem')->name('electronics_classifieds.delete');

	Route::get('jobs-classified', 'Admin\JobsClassifiedsController@index')->name('jobs_classifieds.index');
	Route::post('jobs-classified-change-type', 'Admin\JobsClassifiedsController@changeType')->name('jobs_classifieds.change_type');
	Route::get('jobs-classified/{id}', 'Admin\JobsClassifiedsController@viewItem')->name('jobs_classifieds.view');
	Route::get('jobs-classified-delete/{id}', 'Admin\JobsClassifiedsController@deleteItem')->name('jobs_classifieds.delete');

	Route::get('realestate-classified', 'Admin\RealEstateController@index')->name('realestate_classifieds.index');
	Route::post('realestate-classified-change-type', 'Admin\RealEstateController@changeType')->name('realestate_classifieds.change_type');
	Route::get('realestate-classified/{id}', 'Admin\RealEstateController@viewItem')->name('realestate_classifieds.view');
	Route::get('realestate-classified-delete/{id}', 'Admin\RealEstateController@deleteItem')->name('realestate_classifieds.delete');

	Route::get('slider', 'Admin\SliderController@index')->name('slider.index');
	Route::get('slider-form/{id?}', 'Admin\SliderController@getForm')->name('slider.form');
	Route::post('slider-form/{id?}', 'Admin\SliderController@submitForm')->name('slider.submit');
	Route::get('slider-delete/{id}', 'Admin\SliderController@deleteItem')->name('slider.delete');

	Route::get('home-advertisement', 'Admin\HomeAdvertisementController@index')->name('home_advertisement.index');
	Route::get('home-advertisement-form/{id?}', 'Admin\HomeAdvertisementController@getForm')->name('home_advertisement.form');
	Route::post('home-advertisement-form/{id?}', 'Admin\HomeAdvertisementController@submitForm')->name('home_advertisement.submit');
	Route::get('home-advertisement-delete/{id}', 'Admin\HomeAdvertisementController@deleteItem')->name('home_advertisement.delete');

	Route::get('national-events', 'Admin\NationalEventController@index')->name('national_events.index');
	Route::get('national-events-form/{id?}', 'Admin\NationalEventController@getForm')->name('national_events.form');
	Route::post('national-events-form/{id?}', 'Admin\NationalEventController@submitForm')->name('national_events.submit');
	Route::get('national-events-delete/{id}', 'Admin\NationalEventController@deleteItem')->name('national_events.delete');

	Route::get('national-batches', 'Admin\NationalBatchController@index')->name('national_batches.index');
	Route::get('national-batches-form/{id?}', 'Admin\NationalBatchController@getForm')->name('national_batches.form');
	Route::post('national-batches-form/{id?}', 'Admin\NationalBatchController@submitForm')->name('national_batches.submit');
	Route::get('national-batches-delete/{id}', 'Admin\NationalBatchController@deleteItem')->name('national_batches.delete');

	Route::any('user', 'Admin\UserController@index')->name('user.index');
	Route::get('user-form/{id?}', 'Admin\UserController@getForm')->name('user.form');
	Route::post('user-form/{id?}', 'Admin\UserController@submitForm')->name('user.submit');
	Route::get('user-delete/{id}', 'Admin\UserController@deleteItem')->name('user.delete');
	Route::get('user-details-autocomplete', 'Admin\UserController@userDetailsAutocomplete')->name('user.autocomplete');

	Route::get('admin-user', 'Admin\AdminUserController@index')->name('admin.index');
	Route::get('admin-user-form/{id?}', 'Admin\AdminUserController@getForm')->name('admin.form');
	Route::post('admin-user-form/{id?}', 'Admin\AdminUserController@submitForm')->name('admin.submit');
	Route::get('admin-user-delete/{id}', 'Admin\AdminUserController@deleteItem')->name('admin.delete');

	Route::get('nri-card', 'Admin\NRICardController@index')->name('nricard.index');
	Route::get('nri-card-form/{id?}', 'Admin\NRICardController@getForm')->name('nricard.form');
	Route::post('nri-card-form/{id?}', 'Admin\NRICardController@submitForm')->name('nricard.submit');
	Route::get('nri-card-delete/{id}', 'Admin\NRICardController@deleteItem')->name('nricard.delete');
	Route::get('nri-card-genrate-code', 'Admin\NRICardController@GenrateCode')->name('nricard.genrate_code');

	Route::get('forum/category', 'Admin\ForumCategoryController@index')->name('forum_category.index');
	Route::get('forum/category-form/{id?}', 'Admin\ForumCategoryController@getForm')->name('forum_category.form');
	Route::post('forum/category-form/{id?}', 'Admin\ForumCategoryController@submitForm')->name('forum_category.submit');
	Route::get('forum/category-delete/{id}', 'Admin\ForumCategoryController@deleteItem')->name('forum_category.delete');

	Route::get('forum/reply', 'Admin\ForumReplyController@index')->name('forum_reply.index');
	Route::get('forum/reply-form/{id?}', 'Admin\ForumReplyController@getForm')->name('forum_reply.form');
	Route::post('forum/reply-form/{id?}', 'Admin\ForumReplyController@submitForm')->name('forum_reply.submit');
	Route::get('forum/reply-delete/{id}', 'Admin\ForumReplyController@deleteItem')->name('forum_reply.delete');

	Route::get('forums', 'Admin\ForumThreadController@index')->name('forum.index');
	Route::get('forums-form/{id?}', 'Admin\ForumThreadController@getForm')->name('forum.form');
	Route::post('forums-form/{id?}', 'Admin\ForumThreadController@submitForm')->name('forum.submit');
	Route::get('forums-delete/{id}', 'Admin\ForumThreadController@deleteItem')->name('forum.delete');

	Route::get('nritalk', 'Admin\NRITalkController@index')->name('nritalk.index');
	Route::get('nritalk-form/{id?}', 'Admin\NRITalkController@getForm')->name('nritalk.form');
	Route::post('nritalk-form/{id?}', 'Admin\NRITalkController@submitForm')->name('nritalk.submit');
	Route::get('nritalk-delete/{id}', 'Admin\NRITalkController@deleteItem')->name('nritalk.delete');
	Route::post('nritalk-change-type', 'Admin\NRITalkController@changeType')->name('nritalk.change_type');

	Route::get('businessess/category', 'Admin\BusinessesCategoryController@index')->name('businessess_category.index');
	Route::get('businessess/category-form/{id?}', 'Admin\BusinessesCategoryController@getForm')->name('businessess_category.form');
	Route::post('businessess/category-form/{id?}', 'Admin\BusinessesCategoryController@submitForm')->name('businessess_category.submit');
	Route::get('businessess/category-delete/{id}', 'Admin\BusinessesCategoryController@deleteItem')->name('businessess_category.delete');

	Route::get('businessess', 'Admin\BusinessesController@index')->name('businesses.index');
	Route::get('businessess-form/{id?}', 'Admin\BusinessesController@getForm')->name('businesses.form');
	Route::post('businessess-form/{id?}', 'Admin\BusinessesController@submitForm')->name('businesses.submit');
	Route::get('businessess-delete/{id}', 'Admin\BusinessesController@deleteItem')->name('businesses.delete');

	Route::get('ratingsource', 'Admin\RatingSourceController@index')->name('ratingsource.index');
	Route::get('ratingsource-form/{id?}', 'Admin\RatingSourceController@getForm')->name('ratingsource.form');
	Route::post('ratingsource-form/{id?}', 'Admin\RatingSourceController@submitForm')->name('ratingsource.submit');
	Route::get('ratingsource-delete/{id}', 'Admin\RatingSourceController@deleteItem')->name('ratingsource.delete');

	Route::get('movie-external-ratings', 'Admin\MovieExternalRatingController@index')->name('movies_external_rating.index');
	Route::get('movie-external-ratings-form/{id?}', 'Admin\MovieExternalRatingController@getForm')->name('movies_external_rating.form');
	Route::post('movie-external-ratings-form/{id?}', 'Admin\MovieExternalRatingController@submitForm')->name('movies_external_rating.submit');
	Route::get('movie-external-ratings-delete/{id}', 'Admin\MovieExternalRatingController@deleteItem')->name('movies_external_rating.delete');

	Route::get('profilesetting-form/{id?}', 'Admin\ProfileSettingController@getForm')->name('profilesetting.form');
	Route::post('profilesetting-form/{id?}', 'Admin\ProfileSettingController@submitForm')->name('profilesetting.submit');

	Route::get('newsvideo', 'Admin\NewsVideoController@index')->name('newsvideo.index');
	Route::get('newsvideo-form/{id?}', 'Admin\NewsVideoController@getForm')->name('newsvideo.form');
	Route::post('newsvideo-form/{id?}', 'Admin\NewsVideoController@submitForm')->name('newsvideo.submit');
	Route::get('newsvideo-delete/{id}', 'Admin\NewsVideoController@deleteItem')->name('newsvideo.delete');

	Route::get('nrireply', 'Admin\NRITalkReplyController@index')->name('nrireply.index');
	Route::get('nrireply-form/{id?}', 'Admin\NRITalkReplyController@getForm')->name('nrireply.form');
	Route::post('nrireply-form/{id?}', 'Admin\NRITalkReplyController@submitForm')->name('nrireply.submit');
	Route::get('nrireply-delete/{id}', 'Admin\NRITalkReplyController@deleteItem')->name('nrireply.delete');

	Route::any('pending-approval', 'Admin\PendingAdsController@index')->name('pending-appro.index');

	Route::any('newsletter-email', 'Admin\SendEmailListController@index')->name('newsletter.index');
	Route::any('send-email-list', 'Admin\SendEmailListController@index')->name('send-email.index');
	Route::get('send_email-delete/{id}', 'Admin\SendEmailListController@deleteItem')->name('send-email.delete');

	Route::any('student_talk-topic', 'Admin\FamousStudenttalkController@studentTalkTopic')->name('studenttalk_topic.index');
	Route::any('student_talk-topic/delete/{id}', 'Admin\FamousStudenttalkController@topic_deleteItem')->name('studenttalk_topic.delete');
});

/*Route::get('/', function () {
return view('welcome');
});
 */
Auth::routes();

// Route::get('/logout', function(){
//     auth()->logout();
//     // return redirect()->;
// });

// Route::get('/update-password', function(){
//     $users = DB::table('users')->get();
//     foreach ($users as $key => $value) {
//         $pass = \Illuminate\Support\Facades\Hash::make($value->password_core);
//         DB::table('users')->where('id', $value->id)->update(['password' => $pass]);
//         echo "<pre>". $pass ." ==> "; print_r($value->password_core); echo "</pre>";
//     }
//     // return redirect()->;
// });

Route::get('/forum', 'ForumController@index')->name('front.forum');
Route::get('/forum/threads/{id}', 'ForumController@viewSubCate')->name('front.forum_subcate');
Route::post('/auth-login', 'AuthController@login')->name('front.login');
Route::get('/logout', 'AuthController@logout')->name('front.logout');
Route::post('/get-states-by-country', 'AuthController@getState');
Route::post('/auth-register', 'AuthController@register')->name('front.register');
Route::get('/get_city', 'Admin\CityController@getByState')->name('front.get_city');
Route::get('/get_state', 'Admin\StateController@getByCountry')->name('front.get_state');

Route::get('google-login', 'Auth\GoogleController@redirectToGoogle')->name('google-login');
Route::any('google-callback', 'Auth\GoogleController@handleGoogleCallback');

Route::get('facebook-login', 'Auth\FacebookController@redirectToFB')->name('facebook-login');
Route::get('facebook-callback', 'Auth\FacebookController@handleCallback');

Route::get('twitter-login', 'Auth\TwitterController@redirectToTwitter')->name('twitter-login');
Route::get('twitter-callback', 'Auth\TwitterController@handleCallback');

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/profile', 'ProfileController@index')->name('front.profile');
	Route::get('/profile_edit', 'ProfileController@initForm')->name('front.profile_edit');
	Route::post('/profile-edit', 'ProfileController@initSubmit')->name('front.profile_submit');
	Route::get('/profile-nri-card', 'ProfileController@nriCard')->name('front.nricard');
	Route::get('/profile/my_ads', 'ProfileController@myAds')->name('front.profile.my_ads');
	Route::get('/profile/my_bid', 'ProfileController@myBid')->name('front.profile.my_bid');
	Route::get('/profile/my_bid/auto/{id}', 'ProfileController@BidDeleteauto')->name('front.profile.auto_bid.delete');
	Route::get('/profile/my_bid/roommate/{id}', 'ProfileController@BidDeleteroommate')->name('front.profile.roommate_bid.delete');

	Route::post('/like-dislike/{id}', 'LikeController@likeToggle')->name('front.like_dislike');
});