<?php

	namespace App\Http\Utilities;


	use App\Like;

	trait Likable {

		public function __construct() {
			$this->fillable[] = 'likes_count';
			$this->fillable[] = 'followers_count';
		}

		public function likes(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Like::class, 'likes');
		}

	}
