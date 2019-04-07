<?php

	namespace App\Http\Controllers;

	use App\City;
	use App\Device;
	use Illuminate\Http\Request;

	class ApiController extends Controller {
		public function main(Request $request) {

			$device_id = $request->header('Device-Id');
			if ( ! $device_id) {
				abort(400);
			}
			$device = Device::where('device_id', $device_id)->first();
			if ($device === NULL) {
				Device::create([
					               'device_id'          => $device_id,
					               'os'                 => $request->os,
					               'model'              => $request->model,
					               'brand'              => $request->brand,
					               'market'             => $request->market,
					               'os_version'         => $request->os_version,
					               'app_version'        => $request->app_version,
					               'notification_token' => $request->notification_token,
				               ]);
			}


			if ($request->city) {
				$city_name = strtolower($request->city);
				$lat = $request->lat;
				$long = $request->long;

			} elseif ($request->lat && $request->long) {
				$lat = $request->lat;
				$long = $request->long;
				$city_name = getCity($request->lat, $request->long);

			} else {
				$ip_info = geoIP($request->getClientIp());
				$city_name = $ip_info->geobytescity();
				$lat = $ip_info->geobyteslatitude();
				$long = $ip_info->geobyteslongitude();
			}
			$city = City::where('title', $city_name)->first();
			if ($city === NULL) {
				$city = City::create([
					                     'title' => $city_name,
				                     ]);
			}

			$nearbyPlaces = placeSearch($lat, $long);

			$results = collect($nearbyPlaces->results);
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

			dd($device);

		}
	}
