<?php

	use Illuminate\Http\Request;


	Route::middleware('auth:api')->get('/user', function (Request $request) {
		return $request->user();
	});


	Route::prefix('countries')->group(function () {
		Route::get('/', 'CountryController@countries');

		Route::prefix('{country}')->group(function () {
			Route::get('/', 'CountryController@getCity');


		});


	});


	Route::middleware('auth:api')->group(function () {

		Route::prefix('countries')->group(function () {
			Route::get('/', 'CountryController@countries');

			Route::prefix('{country}')->group(function () {
				Route::get('/', 'CountryController@getCity');

				Route::prefix('add')->group(function () {

					Route::post('culturalNote', 'CountryController@addCulturalNote');
					Route::post('image', 'CountryController@addImage');
					Route::post('notToMiss/{type}', 'CountryController@addNotToMiss');
				});


			});


		});
	});
	Route::any('/', 'ApiController@main');


	Route::post('/auth/register', 'AuthController@register');
	Route::post('/auth/login', 'AuthController@login');
