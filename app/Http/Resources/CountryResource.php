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
				'title' => NULL,
				'type'  => 'country',
				'model' => [

					'code'     => $this->code,
					'name'     => $this->name,
					'flag'     => url($this->flag),
					'map'      => $this->map,
					'followed' => optional($user)->hasFollowed($this) ?? FALSE,
					'bucketed' => optional($user)->hasBucket($this) ?? FALSE,
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
				],


			];
		}
	}
