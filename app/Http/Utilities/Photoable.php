<?php

	namespace App\Http\Utilities;


	use App\Photo;

	trait Photoable {
		public function photos() {
			return $this->hasMany(Photo::class);
		}

	}
