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
        return [
            'id' => $this->_id,
            'title' => $this->title,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'description' => $this->description,
            'destinations' => $this->destinations
        ];
    }


}
