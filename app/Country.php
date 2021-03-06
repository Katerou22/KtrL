<?php

namespace App;

use App\Http\Utilities\Followable;
use App\Http\Utilities\Photoable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
    use Followable, Photoable;

    protected $fillable = [
        'name', 'code', 'timezone', 'languages', 'population', 'currency', 'phone', 'capital', 'emoji', 'flag', 'map', 'reviews_count',
        'followers_count', 'likes_count', 'image'
    ];

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class, 'country_code', 'code');
    }

    public function cultural_notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CulturalNote::class, 'country_code', 'code');
    }

    public function language_tips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LanguageTip::class, 'country_code', 'code');
    }

    public function not_to_misses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NotToMiss::class, 'country_code', 'code');
    }


    public function reviews(): \Jenssegers\Mongodb\Relations\EmbedsMany
    {
        return $this->embedsMany(Review::class, 'reviews');
    }

    public function rates(): \Jenssegers\Mongodb\Relations\EmbedsMany
    {
        return $this->embedsMany(Rate::class, 'rates');
    }

    public static function getName($name)
    {
        return self::where('name', $name)->first();
    }

    public static function getCode($code)
    {

        $model = self::where('code', strtoupper($code))->first();

        if ($model === NULL) {
            return error('Country Not Found', 404);
        }


        return $model;
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function resolveRouteBinding($value)
    {
        return $this->where($this->getRouteKeyName(), strtoupper($value))->first();
    }

    public function getFlagAttribute($value)
    {
        return url($value);
    }


}
