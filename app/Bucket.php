<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Bucket extends Eloquent {
		protected $fillable = [
			'type', 'id',
		];

		public function parent() {
			$model = ucfirst($this->type);

			return $model::where($model::getRouteKeyName(), $this->id)->first();
		}
	}

