<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
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
            'month_in_digit' => Carbon::createFromTimeString($this->date_at)->month,
            'month' => Carbon::createFromTimeString($this->date_at)->format('M-Y'),
            'date_at' => $this->date_at,
            'performance' => collect($this->performance)
            ->map(fn ($obs, $cat) => [
                'category' => $cat,
                'observations' => collect($obs)->map(fn ($per, $ctr) => [
                    'criteria' => $ctr,
                    'performace' => $per,
                ])->values()
            ])->values(),
        ];
    }
}
