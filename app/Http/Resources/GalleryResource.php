<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'date_at' => $this->date_at->format('d-M-Y'),
            'day' => $this->date_at->format('d'),
            'month' => $this->date_at->format('m'),
            'attachments' => optional($this->attachment)->map->url() ?? [],
        ];
    }
}
