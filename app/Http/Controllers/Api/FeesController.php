<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstallmentResource;
use App\Http\Resources\ReceiptResource;
use App\Models\Admission;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Admission $admission, Request $request)
    {
        $months = \get_months(\get_academic_year(\today(), $admission->school), 'n');
        $request->merge(\compact('months'));
        return [
            'data' => [
                'fees' => ReceiptResource::collection($admission->school_fees_receipts),
                'receipts' => ReceiptResource::collection($admission->general_receipts),
                'installments' => InstallmentResource::collection($admission->installments),
                'invoice_number' => $admission->invoice_no,
                'total_amount' => $admission->total_fees,
                'received_amount' => $admission->paid_fees,
                'balance_amount' => $admission->balance_amount,
            ],
        ];
    }
}
