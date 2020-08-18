<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCity(Request $request)
    {
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
    }
}
