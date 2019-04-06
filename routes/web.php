<?php


	Route::get('/', function () {
		return view('welcome');
	});
	Route::get('/tester', function () {
		dd(getCity('35.6892', '51.3890'));
		//		$country = \App\Country::first();
		//		dd($country->cities()->create(['title' => 'Tehran']));
		//		$place = placeSearch('35.6892', '51.3890');
		//		$res = collect($place->results);
		//		$res = $res->map(function ($item) {
		//			if (in_array('food', $item->types, TRUE)) {
		//				return $item;
		//			}
		//
		//		});
		//		dd($res);
		//		dd($place->whereIn('types', 'locality'));
		//		dd($place);
		//
		//		return api($place);
	});
