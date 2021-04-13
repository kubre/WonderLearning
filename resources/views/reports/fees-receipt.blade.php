<div id="print-report" class="bg-white px-4 py-4">
    <div class="row">
        <div class="col-md-4">
            <img style="max-height: 150px; width: auto;" src="{{ $receipt->admission->student->school->logo }}"
                alt="Logo">
        </div>
        <div class="col-md-3 text-center mt-3">
            <h2 class="text-bold">Receipt</h2>
        </div>
        <div class="col-md-5">
            <table class="w-100">
                <tr>
                    <th>Center Head</th>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $receipt->admission->student->school->address }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $receipt->admission->student->school->contact }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 row">
            <strong class='col-6'>Receipt No.: </strong>
            <span class='col-5 text-right'
                style='border: 1px solid black;'>{{ str_pad($receipt->receipt_no, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>
        <div class="col-md-3">
            <strong>PRN: </strong><span class="px-3 b-b">{{ $receipt->admission->student->prn }}</span>
        </div>
        <div class="col-md-4">
            <strong class='col-3'>Date: </strong>
            <span class='col-4 text-right'>{{ $receipt->receipt_at->format('d-m-Y') }}</span>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3"><strong>Received with thanks from </strong></div>
        <div class="col b-b">
            {{ strtoupper($receipt->admission->student->{$parent . '_name'}) }}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3"><strong>on behalf of </strong></div>
        <div class="col b-b">
            {{ strtoupper($receipt->admission->student->name) }}
        </div>
    </div>
    {{-- sum of (in digits) &lt;amount&gt; on account of &lt;for&gt; in words &lt;amount&gt; only --}}
    <div class="mt-4 d-flex justify-content-between">
        <div>
            <strong>Sum of (in digits) </strong><span class="pl-2 b-b">₹ {{ $receipt->amount }}/- </span>
        </div>
        <div class="px-2">
            <strong>on account of </strong><span class="b-b pl-2">{{ $receipt->for }}</span>
        </div>
        <div><strong>in words:</strong> &nbsp;&nbsp; (<span class='b-b w-100'>
                {{ strtoupper(inr_format($receipt->amount)) }}RUPEES ONLY</span>
            )</div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <strong>Via: </strong>
            <div class='ml-4 b-b d-inline-block'>
                {{ strtoupper(\App\Models\Receipt::PAYMENT_MODES[$receipt->payment_mode]) }}</div>
        </div>
        @if ($receipt->payment_mode != 'c')
            @if ($receipt->payment_mode == 'b')
                <div class="col pl-4">
                    <strong>Bank: </strong>
                    <div class='ml-3 b-b w-50 d-inline-block'> {{ $receipt->bank_name }} </div>
                </div>
                <div class="col-4 pl-5">
                    <strong>Cheque No.: </strong>
                    <div class='ml-4 b-b w-50 d-inline-block'> {{ $receipt->transaction_no }} </div>
                </div>
            @else
                <div class="col-6 pl-5">
                    <strong>Transaction No.: </strong>
                    <div class='ml-4 b-b w-50 d-inline-block'> {{ $receipt->transaction_no }} </div>
                </div>

            @endif
            <div class="col">
                <strong>Dated: </strong> <span class='px-2 b-b'> {{ $receipt->paid_at->format('d-m-Y') }} </span>
            </div>
        @endif
    </div>
    <div class="row mt-4">
        <div class="col-md-2"><strong>Invoice No.:</strong></div>
        <div class="col-md-2">{{ $receipt->admission->invoice_no }}</div>

        <div class="col-md-2"><strong>Programme:</strong></div>
        <div class="col-md-2">{{ $receipt->admission->program }}</div>

        <div class="col-md-2"><strong>Batch:</strong></div>
        <div class="col-md-2">{{ $receipt->admission->batch }}</div>
    </div>
    <div style='min-height: 5mm'></div>
    <div class="row mt-5">
        <div class="col-8">Cheque / DD subject to realisation</div>
        <div class="col">Accountant</div>
    </div>
    <div class="row mt-4">
        <strong class="col-12">*This is a computer generated receipt does not require signature.</strong>
    </div>
    {{-- <div class="row mt-4 px-3">towards the full or part payment of the total fees of the course mentioned below: </div> --}}
    {{-- <div class="row">
        <div class="col-2"></div>
        <table class="table table-bordered col-6">
            <thead>
                <tr>
                    <th colspan="2">Fees for year {{ get_academic_year_formatted(working_year()) }}</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipt->school->fees->{strtolower($receipt->admission->program)} as $fees)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <th>{{ $fees['fees'] }}</th>
                        <td class='text-right'>{{ $fees['amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan="2">Total</th>
                <th>{{ $receipt->school->fees->{$receipt->admission->fees_total_column} }}</th>
            </tfoot>
        </table>
        <table class="table table-bordered col-4">
            <tr>
                <th>Invoice No.: </th>
                <td>{{ $receipt->admission->invoice_no }}</td>
            </tr>
            <tr>
                <th>Invoice Date.: </th>
                <td>{{ $receipt->admission->invoice_no }}</td>
            </tr>
            <tr>
                <th>Invoice No.: </th>
                <td>{{ $receipt->admission->invoice_no }}</td>
            </tr>
            <tr>
                <th>Invoice No.: </th>
                <td>{{ $receipt->admission->invoice_no }}</td>
            </tr>
        </table>
    </div> --}}
</div>
