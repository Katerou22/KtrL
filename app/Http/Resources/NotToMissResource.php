<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	class NotToMissResource extends JsonResource {
		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {

			return [
				'id'          => $this->id,
				'title'       => $this->title,
				'user'        => new UserResource($this->user),
				'photo'       => url($this->photo),
				'likes_count' => $this->likes_count,
				'is_liked'    => FALSE, //test
				'native'      => $this->user->country->code === $this->country_code,
				'created_at'  => $this->created_at->timestamp,
			];
		}
	}
