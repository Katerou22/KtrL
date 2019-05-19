<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

	/**
	 * @property mixed language_tips
	 * @property mixed cultural_notes
	 * @property mixed flag
	 * @property mixed currency
	 */
	class CountryShowResource extends JsonResource {
		/**
		 * Transform the resource into an array.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return array
		 */
		public function toArray($request) {
			$user = auth('api')->user();

			$culturalNoteList = $this->cultural_notes;
			$languageTip = $this->language_tips;

			$userCulturalNoteList = $user === NULL ? collect([]) : $culturalNoteList->where('user_id', $user->id);
			$userLanguageTip = $user === NULL ? collect([]) : $languageTip->where('user_id', $user->id);

			return [
				'country'              => new CountryResource($this),
				//				'CountrySearchList'             => new CountryResource($this),
				//				'review'               => new CountryResource($this), //is
				//				'reviewList'           => new CountryResource($this),//is
				'culturalNoteList'     => CalturalNoteResource::collection($culturalNoteList),
				'culturalNoteEditList' => CalturalNoteResource::collection($userCulturalNoteList),
				//				'eventSmallList'                => new CountryResource($this),
				//				'eventLargeList'                => new CountryResource($this),
				'languageTipList'      => LanguageTipResource::collection($userCulturalNoteList),//is
				'languageTipEditList'  => LanguageTipResource::collection($userLanguageTip),//is
				//				'TouristTrapVerticalList'       => new CountryResource($this),
				//				'TouristTrapHorizontalList'     => new CountryResource($this),
				//				'TouristTrapEditVerticalList'   => new CountryResource($this),
				//				'TouristTrapEditHorizontalList' => new CountryResource($this),
				//				'newsList'             => new CountryResource($this),//is
				'currency'             => [
					'home'        => [
						'flag'      => $this->flag,
						'base'      => 1 . ' ' . $this->currency,
						'converted' => 1,
					],
					'destination' => [
						'flag'      => $user === NULL ? NULL : $user->country->flag,
						'base'      => $user === NULL ? NULL : 1 . ' ' . $user->country->currency,
						'converted' => 1,
					],
				],
				'notToMiss'            => new CountryResource($this),
				'notToMissEdit'        => new CountryResource($this),
				//				'WeatherDetail'                 => new CountryResource($this),
				//				'WeatherAverage'                => new CountryResource($this),
				//				'placeNormalList'      => new CountryResource($this),//is
				//				'placeLargeList'       => new CountryResource($this),//is
				//				'placeSquareList'      => new CountryResource($this),//is//is
				//				'placeCycleList'       => new CountryResource($this),//is
				//				'PlaceSearchList'               => new CountryResource($this),
				//				'applicationList'      => new CountryResource($this),//is
				//				'Expense'                       => new CountryResource($this),
				//				'ExpenseList'                   => new CountryResource($this),
				//				'evaluation'          => new CountryResource($this),//in Country
				//				'Memorable'                     => new CountryResource($this),
				//				'Arrive'                        => new CountryResource($this),
				//				'Gallery'                       => new CountryResource($this),
				//				'GalleryTop'                    => new CountryResource($this),
				//				'GallerySix'                    => new CountryResource($this),
				//				'CityList'                      => new CountryResource($this),
				//				'CitySearchList'                => new CountryResource($this),
				//				'UserSearchList'                => new CountryResource($this),
				//				'TravelList'                    => new CountryResource($this),
				//				'AboutMe'                       => new CountryResource($this),
				//				'StatList'                      => new CountryResource($this),
				//				'AchievementList'               => new CountryResource($this),
				//				'ContactList'                   => new CountryResource($this),


			];
		}
	}
