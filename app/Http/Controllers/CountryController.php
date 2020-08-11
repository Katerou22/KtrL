<?php

	namespace App\Http\Controllers;

	use App\City;
	use App\Country;
	use App\Http\Resources\CityResource;
	use App\Http\Resources\CountryCollection;
	use App\Http\Resources\CountryShowResource;
	use App\Http\Resources\CulturalNoteResource;
	use App\Http\Resources\LanguageTipResource;
	use App\Http\Resources\NewsResource;
	use App\Http\Resources\NotToMissResource;
	use App\Photo;
	use App\Travel;
	use Carbon\Carbon;
	use Illuminate\Http\Request;

	class CountryController extends Controller {
		public function countries() {


			return api(Country::all()->map(function ($country) {
				return [
					'code' => $country->code,
					'name' => $country->name,
					'flag' => $country->flag,
				];
			}));
		}

		public function getCountry(Country $country) {
			return api(new CountryShowResource($country));


		}

		public function getCountryChild(Country $country, $model, Request $request) {
			$models = [
				'notToMisses'   => ['likes_count', 'created_at', 'title'],
				'culturalNotes' => ['likes_count', 'created_at', 'title'],
				'languageTips'  => ['likes_count', 'created_at', 'language'],
				'cities'        => ['likes_count', 'created_at', 'name'],
			];

			if ( ! array_key_exists($model, $models)) {
				abort(404);
			}
			$sorts = $models[ $model ];
			$sort = $sorts[ 0 ];
			$relationName = \Str::snake($model);
			$resourceName = 'App\Http\Resources\\' . \Str::singular(\Str::studly($relationName)) . 'Resource';

			if ($request->sort) {
				if ( ! in_array($request->sort, $sorts, TRUE)) {
					return error('Wrong Sort Use');
				} else {
					$sort = $request->sort;
				}
			}


			$data = $country->$relationName()->orderBy($sort)->paginate(10);
			$resource = $resourceName::collection($data)->additional(['sorts' => $sorts, 'sorted_by' => $sort]);

			return api($resource);
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

			return api(new CulturalNoteResource($cultural_note));

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

			return api(new LanguageTipResource($language_tip));

		}

		public function addPhotos(Country $country, Request $request) {
			$request->validate([
				                   'photos'   => 'required',
				                   'photos.*' => 'mimes:jpeg,png,jpg',
			                   ]);

			if ($request->city) {
				City::findOrFail($request->city);
			}

			if ($request->travel) {
				Travel::findOrFail($request->travel);
			}


			foreach ($request->photos as $photo) {
				$name = upImage($photo, $country->code . '/photos/', TRUE);
				Photo::create([
					              'user_id'     => auth()->user()->id,
					              'city_id'     => $request->city,
					              'country_id'  => $country->id,
					              'travel_id'   => $request->travel,
					              'path'        => '/images/' . $country->code . '/photos/' . $name,
					              'thumbnail'   => '/thumbnails/' . $country->code . '/photos/' . $name,
					              'likes_count' => 0,
				              ]);

			}


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

			return api(new NotToMissResource($not_to_miss));

		}

		public function getNews(Country $country) {


			return getNews($country->code);
		}

	}
