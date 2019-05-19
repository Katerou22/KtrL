<?php

	namespace App;

	use App\Http\Utilities\Followable;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class City extends Eloquent {
		use Followable;
		protected $fillable = [
			'name', 'country', 'lat', 'lng','followers_count','likes_count',
		];

		public function country() {
			return $this->belongsTo(Country::class, 'country', 'code');
		}

		public function places() {
			return $this->hasMany(Place::class);
		}

		public static function getName($name) {
			return self::where('name', $name)->first();
		}
	}
