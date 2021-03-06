<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\TravelResource;
use App\Travel;
use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;

class TravelController extends Controller
{
    public function get(Travel $travel)
    {
        return api(new TravelResource($travel));
    }

    public function create(Request $request, Country $country)
    {

        $destinations = [];

        $destinations[] = [
            [
                'code' => $country->code,
                'name' => $country->name,
                'cities' => [],

            ]
        ];
        $travel = Travel::create([
            'title' => $request->title,
            'started_at' => new UTCDateTime($request->started_at),
            'ended_at' => null,
            'description' => $request->description,
            'user_id' => $this->user->id,
            'destinations' => $destinations,
            'finished' => false,
        ]);


        return api(['travel' => new TravelResource($travel)]);

    }

    public function update(Request $request, Travel $travel)
    {
        if ($this->user->id === $travel->user_id) {
            $travel->update([
                'title' => $request->title,
                'started_at' => new UTCDateTime($request->started_at),
                'ended_at' => $request->ended_at === null ?: new UTCDateTime($request->ended_at),
                'description' => $request->description,
                'finished' => false,]);

        }
        return api(['travel' => new TravelResource($travel)]);

    }


//
//    public function update(Request $request, Travel $travel)
//    {
//        if ($this->user->id === $travel->user_id) {
//            $travel->update([
//                'title' => $request->title,
//                'started_at' => new UTCDateTime($request->started_at),
//                'ended_at' => $request->ended_at === null ?: new UTCDateTime($request->ended_at),
//                'description' => $request->description,
//                'finished' => false,]);
//
//        }
//        return api(['travel' => new TravelResource($travel)]);
//
//    }
}
