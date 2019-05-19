<?php

	namespace App\Http\Utilities;

	use App\Follow;

	trait Followable {

		public function followers(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Follow::class, 'followers');
		}
	}
