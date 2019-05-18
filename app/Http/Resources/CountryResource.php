<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	class CountryResource extends JsonResource {

		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {


			return [
				'code'          => $this->code,
				'name'          => $this->name,
				'flag'          => url($this->flag),
				'image'         => $this->image,
				'reviews_count' => $this->reviews_count,
				'map'           => $this->map,
				'followed'      => optional(\Auth::user())->hasFollowed($this) !== NULL,
				'bucketed'      => optional(\Auth::user())->hasBucket($this) !== NULL,
				'extra'         => [
					[
						'key'   => 'Timezone',
						'value' => $this->timezone,
					],
					[
						'key'   => 'Language',
						'value' => ucfirst($this->lang),
					],
					[
						'key'   => 'Population',
						'value' => $this->population,
					],
					[
						'key'   => 'Currency',
						'value' => $this->currency,
					],
					[
						'key'   => 'Capital',
						'value' => $this->capital,
					],

				],
			];
		}
	}
