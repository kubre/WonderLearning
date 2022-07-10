<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'body' => $this->body,
            'sent_at' => $this->sent_at->setTimezone('Asia/Kolkata')->format("d-M-Y h:i A"),
            'is_teacher' => $this->is_teacher
        ];
    }
}
