<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Capital extends Eloquent {
		protected $fillable = [
			'title',
			'capital',
			'lat',
			'long',
		];
	}
