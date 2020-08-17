<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Device;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255|string',
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
        $user = User::where('email', $email)->first();
        if ($user !== null) {
            if (!Hash::check($request->password, $user->password)) {
                return error('Not match credentials', 2002);

            } else {
                $device = Device::where('device_id', $request->header('Device-Id'))->first();
                if ($device !== NULL) {
                    $user->devices()->attach($device);
                } else {
                    $user->devices()->create([
                        'os' => strtolower($request->os),
                        'device_id' => $request->header('Device-Id'),
                        'os_version' => $request->os_version,
                        'app_version' => $request->app_version,
                        'market' => $request->market,
                        'brand' => $request->brand,
                        'model' => $request->model,
                        'notification_token' => $request->notification_token,
                    ]);

                }


                $user_info = [
                    'name' => $user->name,
                    'city' => $user->city->name,
                    'country' => $user->country->name,
                    'email' => $user->email,
                    'level' => $user->level,
                    'exp' => $user->exp,
                    'following_count' => $user->following_count,
                    'follower_count' => $user->follower_count,

                ];
                $data = [
                    'token' => $user->api_token,
                    'user_info' => $user_info,
                ];

                return api($data);
            }
        } else {
            return error('No user found with this email', 2001);

        }

    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|max:255|string',
            'password' => 'required|min:8',
            'name' => 'required',
            'city' => 'required',
            'country' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg',
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


            $user = User::create([
                'email' => $email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
                'city_id' => $request->city,
                'country_code' => $request->country,
                'level' => 1,
                'exp' => 0,
                'followings_count' => 0,
                'followers_count' => 0,


            ]);

            $device = Device::where('device_id', $request->header('Device-Id'))->first();
            if ($device !== NULL) {
                $user->devices()->attach($device);
            } else {
                $user->devices()->create([
                    'os' => strtolower($request->os),
                    'device_id' => $request->header('Device-Id'),
                    'os_version' => $request->os_version,
                    'app_version' => $request->app_version,
                    'market' => $request->market,
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'notification_token' => $request->notification_token,
                ]);

            }

        } else {
            return error('This email has been registered before');
        }
        if ($request->avatar) {
            $name = upImage($request->file('avatar'), '/avatars/', TRUE);
            $user->avatar = '/images/avatars/' . $name;
            $user->save();
        }
        $user_info = [
            'name' => $user->name,
            'city' => $city->name,
            'country' => $country->name,
            'email' => $user->email,
            'level' => $user->level,
            'exp' => $user->exp,
            'avatar' => url($user->avatar),
            'followings_count' => $user->following_count,
            'followers_count' => $user->followers_count,

        ];
        $data = [
            'token' => $user->api_token,
            'user_info' => $user_info,
        ];

        return api($data);
    }

    public function recover(Request $request)
    {
        $request->validate([
            'email' => 'required|string',

        ]);


        if (strstr($request->email, '@') === '@gmail.com') {
            $email = str_replace('.', '', strstr($request->email, '@', TRUE)) . '@gmail.com';
        } else {
            $email = $request->email;
        }
        $user = User::where('email', $email)->first();
        //send email to user


        return api(true);

    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'unique:users|max:255|string',
            'password' => 'min:8',
            'avatar' => 'mimes:jpeg,png,jpg',
        ]);

        if ($request->email) {

            if (strstr($request->email, '@') === '@gmail.com') {
                $email = str_replace('.', '', strstr($request->email, '@', TRUE)) . '@gmail.com';
            } else {
                $email = $request->email;
            }
            $user = User::where('email', $email)->first();
            if ($user === NULL) {
                $this->user->email = $email;
            } else {
                return error('This email has been registered before');
            }

        }
        if ($request->country) {
            if (!$request->city) {
                return error('While changing the country, choosing city is required!');
            } else {
                $country = Country::getCode($request->country);
                $city = City::findOrFail($request->city);


                if ($city->country_code !== $country->code) {
                    return error("$city->name is not for $country->name");
                }

                $this->user->city_id = $request->city;
                $this->user->country_code = $request->country;


            }


        }
        if ($request->city) {
            $city = City::findOrFail($request->city);


            if ($city->country_code !== $this->user->country_code) {
                return error("$city->name is not for " . $this->user->country->name);
            }
            $this->user->city_id = $request->city;

        }

        if ($request->name) {
            $this->user->name = $request->name;
        }
        if ($request->password) {
            if (!$request->old_password) {
                return error('Old Password Required');
            }

            if (Hash::check($request->old_password, $this->user->getAuthPassword())) {
                $this->user->password = Hash::make($request->password);

            } else {
                return error('Password is wrong!');
            }

        }
        if ($request->avatar) {
            //				$name = upImage($request->file('avatar'), '/avatars/', TRUE);
            $avatar = $this->user->avatar;
            if ($avatar !== NULL) {
                if (\File::exists(public_path() . $avatar)) {
                    \File::delete(public_path() . $avatar);
                }


            }
            $name = upImage($request->file('avatar'), '/avatars/', TRUE);
            $avatar = '/images/avatars/' . $name;
            $this->user->avatar = $avatar;


        }
        $this->user->save();

        return api(new UserResource($this->user));


    }

    public function getMe()
    {

    }

    public function updateFcm(Request $request)
    {
        $device = Device::where('device_id', $request->header('Device-Id'))->first();
        if ($device !== NULL) {
            $device->update([
                'notification_token' => $request->notification_token
            ])
        }
        return api(true);
    }
}
