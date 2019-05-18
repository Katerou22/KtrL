<?php


	Route::get('/', function () {
		return view('welcome');
	});
	Route::any('/tester', function (\Illuminate\Http\Request $request) {
		$errs = [];
		$countries = \App\Country::all();
		foreach ($countries as $country) {
			if ($country->map === NULL) {
				$country->update([
					                 'map' => 'http://lorempixel.com/800/500/city/',
				                 ]);

			}


		}


	});

	Auth::routes();
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


	Route::get('/home', 'HomeController@index')->name('home');
