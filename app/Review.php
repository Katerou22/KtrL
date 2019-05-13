<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $fillable = [
		'user_id', 'path', 'likes', 'thumbnail', 'city_id', 'travel_id',
	];

	public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
		return $this->belongsTo(User::class);
	}

	public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
		return $this->belongsTo(City::class);
	}

	public function travel(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
		return $this->belongsTo(Travel::class);
	}
}
