<?php

	namespace App;

	use Illuminate\Notifications\Notifiable;
	use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
	use Jenssegers\Mongodb\Auth\User as Authenticatable;

	/**
	 * @property mixed bookmarks
	 */
	class User extends Authenticatable {
		use Notifiable;

		protected $fillable = [
			'name', 'email', 'password', 'api_token', 'avatar', 'country_id', 'city_id', 'level', 'exp', 'following_count', 'follower_count',
		];
		protected $hidden = [
			'password', 'remember_token',
		];

		protected $casts = [
			'email_verified_at' => 'datetime',
		];

		public function devices(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
			return $this->belongsToMany(Device::class);
		}

		public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(City::class);
		}

		public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
			return $this->belongsTo(Country::class);
		}

		public function photos(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Photo::class, 'photos');
		}

		public function buckets(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Bucket::class, 'buckets');
		}

		public function followings(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Follow::class, 'buckets');
		}

		public function hasBucket($country): ?bool {
			if ($this->buckets->where('country_code', strtoupper($country->code))->eixsts()) {
				return TRUE;
			} else {
				return FALSE;
			}


		}

		public function hasFollowed($country): ?bool {
			if ($this->followings->where('country_code', strtoupper($country->code))->eixsts()) {
				return TRUE;
			} else {
				return FALSE;
			}


		}

		public function cultural_notes(): \Illuminate\Database\Eloquent\Relations\HasMany {
			return $this->hasMany(CulturalNote::class, 'user');
		}

	}
