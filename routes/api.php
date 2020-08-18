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
    Route::get('getMe', 'UserController@getMe');
    Route::get('follow/{type}/{id}', 'UserController@toggleFollow');
    Route::get('like/{type}/{id}', 'UserController@toggleLike');
    Route::get('bucket', 'UserController@addToBucket');
    Route::post('/auth/update', 'AuthController@update');
    Route::prefix('countries')->group(function () {

        Route::prefix('{country}')->group(function () {

            Route::prefix('add')->group(function () {

                Route::post('culturalNote', 'CountryController@addCulturalNote');
                Route::post('languageTip', 'CountryController@addLanguageTip');
                Route::post('photos', 'CountryController@addPhotos');
                Route::post('notToMiss/{type}', 'CountryController@addNotToMiss');
            });


        });


    });
});
//	Route::any('/', 'ApiController@main');


Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/updateFcm', 'AuthController@updateFcm');
Route::post('/auth/recover', 'AuthController@login');

