<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassworkResource extends JsonResource
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
            "date" => $this->completed_at,
            "day" => (int) $this->day,
            "month" => $this->month,
            "year" => (int) $this->year,
            "title" => $this->syllabus->name,
            // "chapter"=> "Chapter",
            // "book"=> "Book",
            // "subject"=> "Subject"
        ];
    }
}
