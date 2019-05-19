<?php

	namespace App;

	use App\Http\Utilities\Followable;
	use App\Http\Utilities\Likable;
	use App\Http\Utilities\Photoable;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
	use Jenssegers\Mongodb\Auth\User as Authenticatable;

	/**
	 * @property mixed bookmarks
	 * @property mixed followings_count
	 * @property mixed id
	 */
	class User extends Authenticatable {
		use Notifiable, Followable, Photoable, Likable;

		protected $fillable = [
			'name', 'email', 'password', 'api_token', 'avatar', 'country_id', 'city_id', 'level', 'exp', 'followings_count', 'followers_count', 'likes_count',
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

		public function buckets(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Bucket::class, 'buckets');
		}

		public function followings(): \Jenssegers\Mongodb\Relations\EmbedsMany {
			return $this->embedsMany(Follow::class, 'followings');
		}

		public function hasBucket($model): ?bool {
			$type = get_class($model->resource);
			$route_key_name = $model->getRouteKeyName();
			if ($this->buckets->where('type', $type)->where('id', $model->$route_key_name)->first() !== NULL) {
				return TRUE;
			} else {
				return FALSE;
			}


		}

		public function hasFollowed($model) {
			$classes = [
				'App\Country',
				'App\City',
				'App\User',
			];

			$type = get_class($model);
			if ( ! in_array($type, $classes, TRUE)) {
				$type = get_class($model->resource);
				if ( ! in_array($type, $classes, TRUE)) {
					return error('Not Model Found');

				}


			}


			$route_key_name = $model->getRouteKeyName();
			$followed = $this->followings->where('type', $type)->where('id', $model->$route_key_name)->first();
			if ($followed !== NULL) {
				return $followed;
			} else {
				return FALSE;
			}


		}

		public function toggleLike($model, $model_name, $id): ?string {

			$hasLiked = $this->hasLiked($model);
			if ( ! $hasLiked) {
				$this->like($model, $model_name, $id);

				return 'liked';
			} else {
				$this->dislike($hasLiked);

				return 'disliked';
			}


		}

		public function like($model, $model_name, $id): void {


			$like = new Like([
				                 'type'    => $model_name,
				                 'user_id' => $this->id,
				                 'id'      => $id,
			                 ]);
			$this->likes()->save($like);
			$like = new Like([
				                 'type'    => $model_name,
				                 'user_id' => $this->id,
				                 'id'      => $id,
			                 ]);
			$model->likes()->save($like);
			$model->likes_count ++;
			$model->save();
		}

		public function dislike($like): void {
			$parent = $like->parent();
			$like = $this->hasLiked($parent);
			if ($like !== FALSE) {
				$like->delete();

				$parent->likes->where('user_id', $this->id)->first()->delete();
				$parent->likes_count --;
				$parent->save();
			}

		}

		public function hasLiked($model) {
			$classes = [
				'App\CulturalNote',
				'App\TouristTrap',
				'App\Review',
				'App\Photo',
				'App\LanguageTip',
				'App\NotToMiss',
			];

			$type = get_class($model);
			if ( ! in_array($type, $classes, TRUE)) {
				$type = get_class($model->resource);
				if ( ! in_array($type, $classes, TRUE)) {
					return error('Not Model Found');

				}


			}


			$route_key_name = $model->getRouteKeyName();
			$liked = $this->likes->where('type', $type)->where('id', $model->$route_key_name)->first();
			if ($liked !== NULL) {
				return $liked;
			} else {
				return FALSE;
			}
		}

		public function cultural_notes(): \Illuminate\Database\Eloquent\Relations\HasMany {
			return $this->hasMany(CulturalNote::class, 'user');
		}

		public function language_tips(): \Illuminate\Database\Eloquent\Relations\HasMany {
			return $this->hasMany(LanguageTip::class, 'user');
		}

		public function toggleFollow($model, $model_name, $id): ?string {

			$hasFollowed = $this->hasFollowed($model);
			if ( ! $hasFollowed) {
				$this->follow($model, $model_name, $id);

				return 'followed';
			} else {
				$this->unfollow($hasFollowed);

				return 'unfollowed';
			}


		}

		public function follow($model, $model_name, $id): void {


			$like = new Follow([
				                   'type'    => $model_name,
				                   'user_id' => $this->id,
				                   'id'      => $id,
			                   ]);
			$this->followings()->save($like);
			$this->followings_count ++;
			$this->save();
			$like = new Follow([
				                   'type'    => $model_name,
				                   'user_id' => $this->id,
				                   'id'      => $id,
			                   ]);
			$model->followers()->save($like);
			$model->followers_count ++;
			$model->save();
		}

		public function unfollow($follow): void {
			$parent = $follow->parent();
			$follow = $this->hasFollowed($parent);
			if ($follow !== FALSE) {
				$follow->delete();

				$parent->followers->where('user_id', $this->id)->first()->delete();
				$parent->followers_count --;
				$parent->save();

				$parent->followers_count --;
				$this->followings_count --;
				$this->save();
			}

		}

	}
