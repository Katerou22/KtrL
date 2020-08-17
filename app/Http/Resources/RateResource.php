<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	class RateResource extends JsonResource {
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
				'id'          => $this->id,
				'title'       => $this->title,
				'rate'       => $this->rate,
				'user'        => new UserResource($this->user),
				'created_at'  => $this->created_at->timestamp,
			];
		}
	}
