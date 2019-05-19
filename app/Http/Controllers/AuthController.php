<?php

	namespace App\Http\Controllers;

	use App\Country;
	use App\Device;
	use App\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Str;

	class AuthController extends Controller {
		public function login(Request $request) {
			$request->validate([
				                   'email'    => 'required|max:255|string',
				                   'password' => 'required|min:8',
			                   ]);
			if ($request->header('Device-Id') === NULL) {
				return error('Device-Id Required');
			}


			if (strstr($request->email, '@') === '@gmail.com') {
				$email = str_replace('.', '', strstr($request->email, '@', TRUE)) . '@gmail.com';
			} else {
				$email = $request->email;
			}
			$login = Auth::guard()->attempt([
				                                'email'    => $email,
				                                'password' => $request->password,
			                                ]);
			if ( ! $login) {
				return error('Not match credentials');


			} else {
				$user = Auth::guard()->user();
				$device = Device::where('device_id', $request->header('Device-Id'))->first();
				if ($device !== NULL) {
					$user->devices()->attach($device);
				} else {
					$user->devices()->create([
						                         'os'                 => strtolower($request->os),
						                         'device_id'          => $request->header('Device-Id'),
						                         'os_version'         => $request->os_version,
						                         'app_version'        => $request->app_version,
						                         'market'             => $request->market,
						                         'brand'              => $request->brand,
						                         'model'              => $request->model,
						                         'notification_token' => $request->notification_token,
					                         ]);

				}
			}
			$user_info = [
				'name'            => $user->name,
				'city'            => $user->city->name,
				'country'         => $user->country->name,
				'email'           => $user->email,
				'level'           => $user->level,
				'exp'             => $user->exp,
				'following_count' => $user->following_count,
				'follower_count'  => $user->follower_count,

			];
			$data = [
				'token'     => $user->api_token,
				'user_info' => $user_info,
			];

			return api($data);
		}

		public function register(Request $request) {
			$request->validate([
				                   'email'    => 'required|unique:users|max:255|string',
				                   'password' => 'required|min:8',
				                   'name'     => 'required',
				                   'city'     => 'required',
				                   'country'  => 'required',
				                   'avatar'   => 'required|mimes:jpeg,png,jpg',
			                   ]);
			if ($request->header('Device-Id') === NULL) {
				return error('Device-Id Required');
			}
			$country = Country::getCode($request->country);
			if ($country === NULL) {
				return error('Country not found');
			}
			$city = $country->cities()->find($request->city);
			if ($city === NULL) {
				return error('City not found');
			}


			if (strstr($request->email, '@') === '@gmail.com') {
				$email = str_replace('.', '', strstr($request->email, '@', TRUE)) . '@gmail.com';
			} else {
				$email = $request->email;
			}
			$user = User::where('email', $email)->first();
			if ($user === NULL) {


				$name = upImage($request->file('avatar'), '/avatars/', TRUE);


				$user = User::create([
					                     'email'           => $email,
					                     'name'            => $request->name,
					                     'password'        => Hash::make($request->password),
					                     'api_token'       => Str::random(60),
					                     'city_id'         => $request->city,
					                     'country_id'      => $request->country,
					                     'level'           => 1,
					                     'exp'             => 0,
					                     'following_count' => 0,
					                     'follower_count'  => 0,
					                     'avatar'          => '/images/' . '/avatars/' . $name,


				                     ]);

				$device = Device::where('device_id', $request->header('Device-Id'))->first();
				if ($device !== NULL) {
					$user->devices()->attach($device);
				} else {
					$user->devices()->create([
						                         'os'                 => strtolower($request->os),
						                         'device_id'          => $request->header('Device-Id'),
						                         'os_version'         => $request->os_version,
						                         'app_version'        => $request->app_version,
						                         'market'             => $request->market,
						                         'brand'              => $request->brand,
						                         'model'              => $request->model,
						                         'notification_token' => $request->notification_token,
					                         ]);

				}

			} else {
				return error('This email has been registered before');
			}

			$user_info = [
				'name'            => $user->name,
				'city'            => $city->name,
				'country'         => $country->name,
				'email'           => $user->email,
				'level'           => $user->level,
				'exp'             => $user->exp,
				'avatar'          => url($user->avatar),
				'following_count' => $user->following_count,

			];
			$data = [
				'token'     => $user->api_token,
				'user_info' => $user_info,
			];

			return api($data);
		}
	}
