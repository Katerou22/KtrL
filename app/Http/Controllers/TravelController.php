<?php

namespace App\Http\Controllers;

use App\Country;
use App\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function get()
    {

    }

    public function create(Request $request)
    {

        $destinations = [];

        $country = Country::getCode($request->country_code);
        $destinations[] = [
            'cities' => [],
            'country' => $country
        ];
        $travel = Travel::create([
            'title' => $request->title,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'description' => $request->description,
            'user_id' => $this->user->id,
            'destinations' => $destinations,
        ]);


        return api(['travel' => $travel]);

    }
}
