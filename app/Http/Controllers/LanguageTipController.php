<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\LanguageTipResource;
use Illuminate\Http\Request;

class LanguageTipController extends Controller
{
    public function add(Request $request)
    {

        $request->validate([
            'original' => 'required|string',
            'translation' => 'required|string',
            'pronunciation' => 'required|string',
            'language' => 'required|string',
        ]);


        $language_tip = $country->language_tips()->create([
            'original' => $request->original,
            'translation' => $request->translation,
            'pronunciation' => $request->pronunciation,
            'user_id' => $this->user->id,
            'language' => $request->language,
            'likes_count' => 0,
        ]);

        return api(new LanguageTipResource($language_tip));

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
