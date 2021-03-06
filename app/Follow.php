<?php

	namespace App;

	use Carbon\Carbon;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Follow extends Eloquent {
		protected $fillable = [
			'type', 'id', 'user_id',
		];

		public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(User::class);
		}

		public function parent() {
			$model = $this->type;

			return $model::where((new $model)->getRouteKeyName(), $this->id)->first();
		}

	}
