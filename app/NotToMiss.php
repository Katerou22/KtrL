<?php

	namespace App;

	use App\Http\Utilities\Likable;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class NotToMiss extends Eloquent {
		use Likable;
		protected $fillable = [
			'title', 'photo', 'type', 'country_code', 'thumbnail', 'user_id', 'travel_id',
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
