<?php

	namespace App\Console\Commands;

	use Carbon\Carbon;
	use Illuminate\Console\Command;

	class addCities extends Command {
		protected $signature = 'addCities';

		public function handle() {
			$this->info(Carbon::now());
			$cities = \DB::collection('cities_list')->get();
			foreach ($cities->groupBy('country')->toArray() as $country => $ciites) {
				$country = \App\Country::getCode($country);
				if ($country !== NULL) {
					if ($country->cities()->count() !== count($ciites)) {
						$this->info($country->name);

						foreach ($cities as $city) {
							$country->cities()->create($city);


						}
					}


				} else {
					$this->error($country);
				}

			}
			$this->info(Carbon::now());

			return 'okay';
		}
	}
