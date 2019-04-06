<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class City extends Eloquent {
		protected $fillable = [
			'title',
		];

		public function country() {
			return $this->belongsTo(Country::class);
		}

		public function places() {
			return $this->hasMany(Place::class);
		}
	}
