<?php

	namespace App;

	use App\Http\Utilities\Followable;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class City extends Eloquent {
		use Followable;
		protected $fillable = [
			'name', 'country_code', 'lat', 'lng', 'followers_count',
		];

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class, 'country_code', 'code');
		}

		public function places(): \Illuminate\Database\Eloquent\Relations\HasMany {
			return $this->hasMany(Place::class);
		}

		public static function getName($name) {
			return self::where('name', $name)->first();
		}
	}
