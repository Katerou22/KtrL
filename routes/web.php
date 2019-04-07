<?php


	Route::get('/', function () {
		return view('welcome');
	});
	Route::any('/tester', function (\Illuminate\Http\Request $request) {

		//		$country = \App\Country::first();
		//		dd($country->cities()->create(['title' => 'Tehran']));
		$place = placeSearch('35.6892', '51.3890');
		$results = collect($place->results);
		$city = \App\City::find('5ca9aa9de7692e066c6c1023');
		foreach ($results as $result) {
			$i = 0;
			$photos = [];
			if (array_key_exists('photos', $result)) {
				foreach ($result->photos as $photo) {
					++ $i;

					getPlacePhoto($photo->photo_reference, $photo->width, $result->id . $i);
					$photos[] = 'img/' . $result->id . $i . '.jpg';
				}
			}
			$city->places()->create([
				                        'id'        => $result->id,
				                        'place_id'  => $result->place_id,
				                        'reference' => $result->reference,
				                        'name'      => $result->name,
				                        'lat'       => $result->geometry->location->lat,
				                        'long'      => $result->geometry->location->lng,
				                        'photos'    => $photos,
			                        ]);


		}

		return 'done';

		$res = $res->map(function ($item) {
			if (in_array('food', $item->types, TRUE)) {
				return $item;
			}

		});
		dd($res);
		dd($place->whereIn('types', 'locality'));
		dd($place);

		return api($place);
	});
