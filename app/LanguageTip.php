<?php

	namespace App;

	use App\Http\Utilities\Likable;
	use Illuminate\Database\Eloquent\Model;

	class LanguageTip extends Model {
		use Likable;
		protected $fillable = [
			'original', 'translation', 'country_code', 'user_id', 'pronunciation',
		];

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}

		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class, 'user_id');
		}
	}
