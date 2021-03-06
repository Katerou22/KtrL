<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Place extends Eloquent {
		protected $fillable = [
			'id',
			'place_id',
			'reference',
			'name',
			'lat',
			'long',
			'photos',
		];
	}
