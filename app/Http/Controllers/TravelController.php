<?php

namespace App\Http\Controllers;

use App\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function get()
    {

    }

    public function create(Request $request)
    {
        $travel = Travel::create([
            'title' => $request->title,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'description' => $request->description,
        ]);


        return api(['travel' => $travel]);

    }
}
