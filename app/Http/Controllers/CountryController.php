<?php

	namespace App\Http\Controllers;

	use App\City;
	use App\Country;
	use App\Http\Resources\CityResource;
	use App\Http\Resources\CountryCollection;
	use App\Http\Resources\CountryResource;
	use App\Http\Resources\CountryShowResource;
	use App\Photo;
	use App\Travel;
	use Illuminate\Http\Request;
	use Intervention\Image\Facades\Image;

	class CountryController extends Controller {
		public function countries() {


			return api(Country::all()->map(function ($country) {
				return [
					'code' => $country->code,
					'name' => $country->name,
					'flag' => url($country->flag),
				];
			}));
		}

		public function getCountry(Country $country) {

			return api(new CountryShowResource($country));


		}

		public function getCity(Country $country) {

			return api(CityResource::collection($country->cities));


		}

		public function addCulturalNote(Country $country, Request $request) {
			$request->validate([
				                   'title'       => 'required|string|min:3|max:64',
				                   'description' => 'required|string|max:450|min:12',
			                   ]);
			$cultural_note = $country->cultural_notes()->create([
				                                                    'title'       => $request->title,
				                                                    'description' => $request->description,
				                                                    'user_id'     => $this->user->id,
				                                                    'likes_count' => 0,
			                                                    ]);

			return api($cultural_note);

		}

		public function addLanguageTip(Country $country, Request $request) {

			$request->validate([
				                   'original'      => 'required|string',
				                   'translation'   => 'required|string',
				                   'pronunciation' => 'required|string',
				                   'language'      => 'required|string',
			                   ]);
			$country_lang = collect($country->languages)->map(function ($l) {

				return $l[ 'code' ];
			});
			if ( ! in_array($request->langauge, $country_lang->toArray(), TRUE)) {
				return error('Wrong Language Selected');
			}

			$language_tip = $country->language_tips()->create([
				                                                  'original'      => $request->original,
				                                                  'translation'   => $request->translation,
				                                                  'pronunciation' => $request->pronunciation,
				                                                  'user_id'       => $this->user->id,
				                                                  'language'      => $request->language,
				                                                  'likes_count'   => 0,
			                                                  ]);

			return api($language_tip);

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
				                   'likes_count'  => 0,
			                   ]);
			$country->photos()->save($photo);
			$this->user->photos()->save($photo);

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
				                                                 'title'       => $request->title,
				                                                 'type'        => $type,
				                                                 'likes_count' => 0,
				                                                 'user_id'     => auth()->user()->id,
				                                                 'travel_id'   => $request->travel,
				                                                 'photo'       => '/images/' . $country->code . '/not_to_misses/' . $type
				                                                                  . '/' .
				                                                                  $photo_name,
				                                                 'thumbnail'   => '/thumbnails/' . $country->code . '/not_to_misses/' .
				                                                                  $type . '/' . $photo_name,
			                                                 ]);

			return api($not_to_miss);

		}

	}
