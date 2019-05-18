<?php


	Route::get('/', function () {
		return view('welcome');
	});
	Route::any('/tester', function (\Illuminate\Http\Request $request) {

		$countries = \App\Country::all();
		foreach ($countries as $country) {
			if ($country->flag === NULL) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, 'https://www.countryflags.io/' . strtolower($country->code) . '/shiny/64.png');

				$data = curl_exec($ch);
				curl_close($ch);
				$path = public_path() . '/images/' . $country->code . '/';

				if ( ! File::isDirectory($path)) {
					File::makeDirectory($path, 493, TRUE);

				}

				\Intervention\Image\Facades\Image::make($data)->save('images/' . $country->code . '/' . $country->code . '.jpg');

				$country->update([
					                 'flag' => '/images/' . $country->code . '/' . $country->code . '.jpg',
				                 ]);
			}


		}


	});

	Auth::routes();
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


	Route::get('/home', 'HomeController@index')->name('home');
