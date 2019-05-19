<?php


	Route::get('/', function () {
		return view('welcome');
	});
	Route::any('/tester', function (\Illuminate\Http\Request $request) {
		$country = \App\Country::first();
		dd($country->followers);


	});

	Auth::routes();
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


	Route::get('/home', 'HomeController@index')->name('home');
