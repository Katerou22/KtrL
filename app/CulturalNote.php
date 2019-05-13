<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class CulturalNote extends Eloquent {
		protected $fillable = [
			'title', 'description', 'country', 'user_id',
		];

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}

		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class, 'user_id');
		}
	}
