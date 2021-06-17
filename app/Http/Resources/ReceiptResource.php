<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
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
            'receipt_no' => $this->receipt_no,
            'amount' => $this->amount,
            'receipt_at' => optional($this->receipt_at)->format('d-M-Y'),
            'for' => $this->for,
            'payment_mode' => $this->payment_mode,
            'payment_mode_name' => $this->mode,
            'bank_name' => $this->bank_name,
            'bank_branch' => $this->bank_branch,
            'transactions_no' => $this->transaction_no,
            'paid_at' => optional($this->paid_at)->format('d-M-Y'),
        ];
    }
}
