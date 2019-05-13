<?php

	namespace App\Http\Controllers;

	use App\City;
	use App\Country;
	use App\Photo;
	use App\Travel;
	use Illuminate\Http\Request;
	use Intervention\Image\Facades\Image;

	class CountryController extends Controller {
		public function countries() {
			return api(Country::all());
		}

		public function getCity(Country $country) {

			return api($country->cities);


		}

		public function addCulturalNote(Country $country, Request $request) {
			$request->validate([
				                   'title'       => 'required|string|min:3|max:64',
				                   'description' => 'required|string|max:450|min:12',
			                   ]);
			$cultural_note = $country->cultural_notes()->create($request->only('title', 'description'));

			return api($cultural_note);

		}

		public function addImage(Country $country, Request $request) {
			$request->validate([
				                   'photo' => 'required|mimes:jpeg,png,jpg',
			                   ]);


			if ($request->city) {
				City::findOrFail($request->city);
			}

			if ($request->travel) {
				Travel::findOrFail($request->travel);
			}


			$name = upImage($request->file('photo'), $country->code . '/photos/', TRUE);
			$photo = new Photo([
				                   'user_id'      => auth()->user()->id,
				                   'city_id'      => $request->city,
				                   'country_code' => $country->code,
				                   'travel_id'    => $request->travel,
				                   'path'         => '/images/' . $country->code . '/photos/' . $name,
				                   'thumbnail'    => '/thumbnails/' . $country->code . '/photos/' . $name,
				                   'likes'        => 0,
			                   ]);
			$user = auth()->user();
			$country->photos()->save($photo);
			$user->photos()->save($photo);

			return api('Done');
		}

		public function addNotToMiss(Country $country, $type, Request $request) {
			$request->validate([
				                   'title' => 'required|string|min:3|max:64',
				                   'photo' => 'required|mimes:jpeg,png,jpg',
			                   ]);
			if ($request->travel) {
				Travel::findOrFail($request->travel);
			}
			$photo_name = upImage($request->file('photo'), $country->code . '/not_to_misses/' . $type . '/', TRUE);


			$not_to_miss = $country->not_to_misses()->create([
				                                                 'title'     => $request->title,
				                                                 'type'      => $type,
				                                                 'likes'     => 0,
				                                                 'user_id'   => auth()->user()->id,
				                                                 'travel_id' => $request->travel,
				                                                 'photo'     => '/images/' . $country->code . '/not_to_misses/' . $type
				                                                                . '/' .
				                                                                $photo_name,
				                                                 'thumbnail' => '/thumbnails/' . $country->code . '/not_to_misses/' .
				                                                                $type . '/' . $photo_name,
			                                                 ]);

			return api($not_to_miss);

		}
	}
