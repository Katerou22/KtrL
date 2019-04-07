<?php

	namespace App;

	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

	class Device extends Eloquent {
		protected $fillable = [
			'device_id',
			'model',
			'brand',
			'market',
			'os',
			'os_version',
			'app_version',
			'notification_token',

		];

		public function users() {
			return $this->belongsToMany(User::class);
		}
	}
