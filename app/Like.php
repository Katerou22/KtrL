<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Like extends Eloquent {
		protected $fillable = [
			'user_id', 'type', 'id',
		];


		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class);
		}

		public function parent() {
			$model = $this->type;

			return $model::where((new $model)->getRouteKeyName(), $this->id)->first();
		}
	}
