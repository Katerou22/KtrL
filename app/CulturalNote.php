<?php

namespace App;

use App\Http\Utilities\Likable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CulturalNote extends Eloquent
{
    use Likable;

    protected $fillable = [
        'title', 'description', 'country_code', 'user_id', 'followers_count', 'likes_count', 'travel_id', 'city_id'
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
