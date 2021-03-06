<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	class UserResource extends JsonResource {
		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {
			return [
				'id'              => $this->id,
				'name'            => $this->name,
				'email'           => $this->email,
				'country'         => $this->country->name,
				'city'            => $this->city->name,
				'level'           => $this->level,
				'exp'             => $this->exp,
				'following_count' => $this->following_count,
				'avatar'          => url($this->avatar),
			];
		}
	}
