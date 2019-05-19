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
			$user = auth('api')->user();

			return [
				'code'     => $this->code,
				'name'     => $this->name,
				'flag'     => url($this->flag),
				'map'      => $this->map,
				'followed' => optional($user)->hasFollowed($this),
				'bucketed' => optional($user)->hasBucket($this),
				'extra'    => [
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
