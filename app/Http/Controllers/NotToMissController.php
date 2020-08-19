<?php

namespace App\Http\Controllers;

use App\CulturalNote;
use App\Http\Resources\CulturalNoteResource;
use App\Http\Resources\NotToMissResource;
use App\NotToMiss;
use App\Travel;
use Illuminate\Http\Request;

class NotToMissController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:64',
            'photo' => 'required|mimes:jpeg,png,jpg',
        ]);

        $photo_name = upImage($request->file('photo'), '/not_to_misses/' . $request->type . '/', TRUE);


        $not_to_miss = NotToMiss::create([
            'title' => $request->title,
            'type' => $request->type,
            'likes_count' => 0,
            'user_id' => auth()->user()->id,
            'travel_id' => $request->travel_id,
            'country_code' => $request->country_code,
            'city_id' => $request->city_id,
            'photo' => '/images/not_to_misses/' . $request->type
                . '/' .
                $photo_name,
            'thumbnail' => '/thumbnails/not_to_misses/' .
                $request->type . '/' . $photo_name,
        ]);

        return api(new NotToMissResource($not_to_miss));

    }


    public function update(CulturalNote $culturalNote, Request $request)
    {
        if ($this->user->id === $culturalNote->user_id) {
            $culturalNote->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return api(new CulturalNoteResource($culturalNote));

    }

    public function delete(CulturalNote $culturalNote)
    {
        if ($this->user->id === $culturalNote->user_id) {
            $culturalNote->delete();
        }

        return api(true);
    }

}
