<?php

	namespace App;

	use App\Http\Utilities\Likable;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class LanguageTip extends Eloquent {
		use Likable;
		protected $fillable = [
			'original', 'translation', 'country_code', 'user_id', 'pronunciation', 'followers_count', 'likes_count', 'language',
		];

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}

		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class, 'user_id');
		}
	}
