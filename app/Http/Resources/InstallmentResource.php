<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
{
    protected array $months = [];
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
            'month' => $request->months[$this->month] ?? 'NA',
            'amount' => $this->amount,
            'due_amount' => $this->due_amount,
            'paid_amount' => $this->paid_amount,
        ];
    }

    public function months(array $months): InstallmentResource
    {
        $this->months = $months;
        return $this;
    }
}
