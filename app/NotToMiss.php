<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class NotToMiss extends Eloquent {
		protected $fillable = [
			'title', 'photo', 'type', 'country_code', 'likes', 'thumbnail', 'user_id', 'travel_id',
		];

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}

		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class);
		}

		public function travel(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Travel::class);
		}
	}
