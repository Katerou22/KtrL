<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Follow extends Eloquent {
		protected $fillable = [
			'type', 'id',
		];

		public function parent() {
			$model = ucfirst($this->type);

			return $model::where($model::getRouteKeyName(), $this->id)->first();
		}
	}
