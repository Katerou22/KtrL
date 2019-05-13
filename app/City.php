<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class City extends Eloquent {
		protected $fillable = [
			'name', 'country', 'lat', 'lng',
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
