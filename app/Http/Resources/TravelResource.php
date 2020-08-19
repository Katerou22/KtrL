<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {

        $countries_count = 0;
        $cities_count = 0;

        foreach ($this->destinations as $destination) {
            $countries_count++;
            foreach ($destination->cities as $city) {
                $cities_count++;
            }
        }


        return [
            'id' => $this->_id,
            'title' => $this->title,
            'started_at' => $this->started_at->timestamp,
            'ended_at' => $this->ended_at->timestamp,
            'description' => $this->description,
            'destinations' => $this->destinations,
            'countries_count' => $countries_count,
            'cities_count' => $cities_count,
        ];
    }


}
