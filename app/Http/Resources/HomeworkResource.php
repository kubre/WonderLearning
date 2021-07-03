<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
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
            'body' => $this->body,
            'date_at' => $this->date_at->format('d-M-Y'),
            'day' => $this->date_at->format('d'),
            'month' => $this->date_at->format('m'),
            'attachment' => optional($this->attachment()->first())->url(),
        ];
    }
}
