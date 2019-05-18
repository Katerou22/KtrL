<?php

	namespace App\Http\Controllers;

	use App\Country;
	use Illuminate\Http\Request;

	class UserController extends Controller {
		public function addToBucket(Country $country): void {
			$this->user->buckets()->create([
				                               'country_code' => $country->code,
			                               ]);


		}

		public function follow(): void {
			$this->user->followings()->create([
				                                  'country_code' => $country->code,
			                                  ]);


		}
	}
