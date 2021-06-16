<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'date' => $this->divisionAttendance->date_at,
            'day' => (int) $this->divisionAttendance->day,
            'month' => $this->divisionAttendance->month,
            'year' => (int) $this->divisionAttendance->year,
            'attendance' => $this->status,
        ];
    }
}
