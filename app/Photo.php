<?php

	namespace App;

	use App\Http\Utilities\Likable;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Photo extends Eloquent {
		use Likable;
		protected $fillable = [
			'user_id', 'path', 'thumbnail', 'city_id', 'travel_id', 'country_id', 'followers_count', 'likes_count',
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
