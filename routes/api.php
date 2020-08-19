<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('countries')->group(function () {
    Route::get('/', 'CountryController@countries');

    Route::prefix('{country}')->group(function () {
        Route::get('/', 'CountryController@getCountry');
        Route::get('/news', 'CountryController@getNews');
        Route::get('/{model}', 'CountryController@getCountryChild');


    });


});


Route::middleware('auth:api')->group(function () {
    Route::get('getMe', 'AuthController@getMe');
    Route::get('follow/{type}/{id}', 'UserController@toggleFollow');
    Route::get('like/{type}/{id}', 'UserController@toggleLike');
    Route::get('bucket', 'UserController@addToBucket');
    Route::post('/auth/update', 'AuthController@update');

    Route::prefix('countries')->group(function () {

//        Route::prefix('{country}')->group(function () {
//
//            Route::prefix('add')->group(function () {
//
//                Route::post('culturalNote', 'CulturalNoteController@add');
//                Route::post('languageTip', 'LanguageTipController@add');
//                Route::post('photos', 'PhotosController@add');
//                Route::post('notToMiss/{type}', 'NotToMissController@add');
//            });
//
//
//        });


    });


    Route::prefix('culturalNotes')->group(function () {
        Route::post('create', 'CulturalNoteController@add');


        Route::prefix('{culturalNote}')->group(function () {

            Route::post('update', 'CulturalNoteController@update');
            Route::get('delete', 'CulturalNoteController@delete');


        });


    });


    Route::prefix('languageTips')->group(function () {
        Route::post('create', 'LanguageTipController@add');


        Route::prefix('{languageTip}')->group(function () {

            Route::post('update', 'LanguageTipController@update');
            Route::get('delete', 'LanguageTipController@delete');


        });


    });

    Route::prefix('photos')->group(function () {
        Route::post('create', 'PhotoController@add');


        Route::prefix('{photo}')->group(function () {

            Route::post('update', 'PhotoController@update');
            Route::get('delete', 'PhotoController@delete');


        });


    });


    Route::prefix('notToMiss')->group(function () {
        Route::post('create', 'NotToMissController@add');


        Route::prefix('{notToMiss}')->group(function () {

            Route::post('update', 'NotToMissController@update');
            Route::get('delete', 'NotToMissController@delete');


        });


    });


    Route::prefix('travels')->group(function () {
        Route::post('{country}/create', 'TravelController@create');


        Route::prefix('{travel}')->group(function () {
            Route::get('/', 'TravelController@get');
            Route::post('/update', 'TravelController@post');

//            Route::prefix('add')->group(function () {
//
//                Route::post('culturalNote', 'CountryController@addCulturalNote');
//                Route::post('languageTip', 'CountryController@addLanguageTip');
//                Route::post('photos', 'CountryController@addPhotos');
//                Route::post('notToMiss/{type}', 'CountryController@addNotToMiss');
//            });


        });


    });


});
//	Route::any('/', 'ApiController@main');


Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/updateFcm', 'AuthController@updateFcm');
Route::post('/auth/recover', 'AuthController@login');

