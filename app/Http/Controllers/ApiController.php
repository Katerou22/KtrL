<?php

	namespace App\Http\Controllers;

	use App\Device;
	use Illuminate\Http\Request;

	class ApiController extends Controller {
		public function main(Request $request) {
			if ($request->city) {
				$city_name = $request->city;
			} elseif ($request->lat && $request->long) {
				$city_name = getCity($request->lat, $request->long);
			} else {
				$city_name = 'kermanshah';
			}
			dd($city_name);
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
			dd($device);

		}
	}
