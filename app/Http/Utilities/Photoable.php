<?php

	namespace App\Http\Utilities;


	use App\Photo;

	trait Photoable {
		public function photos(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Photo::class, 'photos');
		}

	}
