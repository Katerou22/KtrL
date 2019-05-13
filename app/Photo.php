<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Photo extends Eloquent {
		protected $fillable = [
			'user_id', 'path', 'likes', 'thumbnail', 'city_id', 'travel_id', 'country_code',
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

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}
	}
