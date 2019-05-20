<?php

	namespace App\Http\Controllers;

	use App\Country;
	use App\Follow;
	use App\Photo;
	use Illuminate\Http\Request;

	class UserController extends Controller {
		public function addToBucket(Country $country): void {
			$this->user->buckets()->create([
				                               'country_code' => $country->code,
			                               ]);


		}

		public function toggleFollow($type, $id) {

			$classes = [
				'Country',
				'City',
				'User',
			];
			if ( ! in_array($type, $classes, TRUE)) {
				return error('Incorrect type entered!');
			}
			$model_name = 'App\\' . $type;
			$model = $model_name::where((new $model_name)->getRouteKeyName(), $id)->first();
			if ($model === NULL) {
				return error("$type Not Found", 404);

			}

			return api($this->user->toggleFollow($model, $model_name, $id));


		}

		public function toggleLike($type, $id) {
			$classes = [
				'CulturalNote',
				'TouristTrap',
				'Review',
				'Photo',
				'LanguageTip',
				'NotToMiss',
			];
			if ( ! in_array($type, $classes, TRUE)) {
				return error('Incorrect type entered!');
			}
			$model_name = 'App\\' . $type;
			$model = $model_name::where((new $model_name)->getRouteKeyName(), $id)->first();

			if ($model === NULL) {
				return error("$type Not Found", 404);

			}

			return api($this->user->toggleLike($model, $model_name, $id));

		}
	}
