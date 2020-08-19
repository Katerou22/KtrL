<?php

namespace App\Http\Controllers;

use App\CulturalNote;
use App\Http\Resources\CulturalNoteResource;
use Illuminate\Http\Request;

class CulturalNoteController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:64',
            'description' => 'required|string|max:450|min:12',
        ]);
        $cultural_note = CulturalNote::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $this->user->id,
            'country_code' => $request->country_code,
            'city_id' => $request->city_id,
            'travel_id' => $request->travel_id,
            'likes_count' => 0,
        ]);

        return api(new CulturalNoteResource($cultural_note));

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
