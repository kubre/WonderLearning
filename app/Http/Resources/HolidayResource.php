<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'notice' => $this->notice ?? '-- No Notice --',
            'start_at' => $this->start_at->format('d-M-Y'),
            'end_at' => optional($this->end_at)->format('d-M-Y'),
        ];
    }
}
