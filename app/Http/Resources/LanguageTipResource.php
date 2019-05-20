<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	class LanguageTipResource extends JsonResource {
		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {
			$user = auth('api')->user();

			return [

				'id'            => $this->id,
				'title'         => $this->title,
				'user'          => new UserResource($this->user),
				'original'      => $this->original,
				'translation'   => $this->translation,
				'pronunciation' => $this->pronunciation,
				'likes_count'   => $this->likes_count,
				'is_liked'      => (bool) optional($user)->hasLiked($this->resource),
				'native'        => $this->user->country->code === $this->country_code,
				'created_at'    => $this->created_at->timestamp,


			];
		}
	}
