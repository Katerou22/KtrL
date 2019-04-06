<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;

	class Device extends Model {
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
