<?php

	namespace App\Http\Utilities;


	use App\Like;

	trait Likable {



		public function likes(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Like::class, 'likes');
		}

	}
