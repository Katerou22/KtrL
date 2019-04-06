<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Country extends Eloquent {
		protected $fillable = [
			'title',
		];

		public function cities() {
			return $this->hasMany(City::class);
		}
	}
