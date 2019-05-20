<?php

	namespace App\Http\Resources;

	use Illuminate\Http\Resources\Json\JsonResource;

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
			$culturalNoteList = $this->resource->cultural_notes()->orderBy('likes_count')->take(5)->get() ?? collect([]);
			$languageTip = $this->resource->language_tips()->orderBy('likes_count')->take(5)->get() ?? collect([]);

			//			$userCulturalNoteList = $user === NULL ? collect([]) : $culturalNoteList->where('user_id', $user->id);
			//			$userLanguageTip = $user === NULL ? collect([]) : $languageTip->where('user_id', $user->id);
			$data = [];
			$data[] = new CountryResource($this);
			$culturalNoteResource = CulturalNoteResource::collection($culturalNoteList);
			if ($culturalNoteResource->count() > 0) {
				$data[] = [
					'title' => 'Cultural Note',
					'type'  => 'culturalNote',
					'model' => $culturalNoteResource,
				];
			}

			$languageTipResource = LanguageTipResource::collection($languageTip);
			if ($languageTipResource->count() > 0) {
				$data[] = [
					'title' => 'Language Tip',
					'type'  => 'languageTip',
					'model' => $languageTipResource,
				];
			}

			$data[] = [
				'title' => 'Currency',
				'type'  => 'currency',
				'model' => [
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
			];

			$notToMissResource = NotToMissesResource::collection($this->resource->not_to_misses()->orderBy('likes_count')->take(5)->get()->groupBy
			                                                     ('type') ?? collect([]));
			if ($notToMissResource->count() > 0) {
				$data[] = [
					'title' => 'Not To Miss',
					'type'  => 'notToMiss',
					'model' => $notToMissResource,
				];
			}

			$photoResource = PhotoResource::collection($this->resource->photos()->orderBy('likes_count')->take(5)->get() ?? collect([]));
			if ($photoResource->count() > 0) {
				$data[] = [
					'title' => 'Photos',
					'type'  => 'photo',
					'model' => [
						'count'  => count($this->photos->count()),
						'photos' => $photoResource,
					],
				];
			}


			return $data;

			//			return [
			//
			//				//				'CountrySearchList'             => new CountryResource($this),
			//				//				'review'               => new CountryResource($this), //is
			//				//				'reviewList'           => new CountryResource($this),//is
			//				//				'culturalNoteEditList' => CulturalNoteResource::collection($userCulturalNoteList) //if is in travel,
			//				//				'eventSmallList'                => new CountryResource($this),
			//				//				'eventLargeList'                => new CountryResource($this),
			//				//is
			//				//				'languageTipEditList'  => LanguageTipResource::collection($userLanguageTip),//is//if is in travel,
			//				//				'TouristTrapVerticalList'       => new CountryResource($this),
			//				//				'TouristTrapHorizontalList'     => new CountryResource($this),
			//				//				'TouristTrapEditVerticalList'   => new CountryResource($this),
			//				//				'TouristTrapEditHorizontalList' => new CountryResource($this),
			//				//				'newsList'             => new CountryResource($this),//is
			//
			//				//				'notToMissEdit'    => new CountryResource($this),//if is in travel,
			//				//				'WeatherDetail'                 => new CountryResource($this),
			//				//				'WeatherAverage'                => new CountryResource($this),
			//				//				'placeNormalList'      => new CountryResource($this),//is
			//				//				'placeLargeList'       => new CountryResource($this),//is
			//				//				'placeSquareList'      => new CountryResource($this),//is//is
			//				//				'placeCycleList'       => new CountryResource($this),//is
			//				//				'PlaceSearchList'               => new CountryResource($this),
			//				//				'applicationList'      => new CountryResource($this),//is
			//				//				'Expense'                       => new CountryResource($this),
			//				//				'ExpenseList'                   => new CountryResource($this),
			//				//				'evaluation'          => new CountryResource($this),//in Country
			//				//				'Memorable'                     => new CountryResource($this),
			//				//				'Arrive'                        => new CountryResource($this),
			//				//				'Gallery'                       => new CountryResource($this),
			//				//				'GalleryTop'                    => new CountryResource($this),
			//				//				'GallerySix'                    => new CountryResource($this),
			//				//				'CityList'                      => new CountryResource($this),
			//				//				'CitySearchList'                => new CountryResource($this),
			//				//				'UserSearchList'                => new CountryResource($this),
			//				//				'TravelList'                    => new CountryResource($this),
			//				//				'AboutMe'                       => new CountryResource($this),
			//				//				'StatList'                      => new CountryResource($this),
			//				//				'AchievementList'               => new CountryResource($this),
			//				//				'ContactList'                   => new CountryResource($this),
			//
			//
			//			];
		}
	}
