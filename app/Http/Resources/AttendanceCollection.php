<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
                ->groupBy('divisionAttendance.month')
                ->map(fn ($item) => $item->mapWithKeys(
                    fn ($itemA) => [$itemA->divisionAttendance->day => $itemA->status]
                )),
        ];
    }
}
