<div id="print-report" class="bg-white px-4 py-4">
    <div class="row">
        <div class="col-md-4">
            <img style="height: auto; max-width: 80%;" src="{{ $receipt->school->logo }}" alt="Logo">
        </div>
        <div class="col-md-3 text-center mt-3">
            <h2 class="text-bold">Receipt</h2>
        </div>
        <div class="col-md-5">
            <p>{{ $receipt->school->center_head->name }}</p>
            <p>{{ $receipt->school->address }}</p>
            <p>Contact {{ $receipt->school->contact }}</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 row">
            <strong class='col-6'>Receipt No.: </strong>
            <span class='col-5 text-right'
                style='border: 1px solid black;'>{{ str_pad($receipt->receipt_no, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-4">
            <strong class='col-3'>Date: </strong>
            <span class='col-4 text-right'>{{ $receipt->receipt_at->format('d-m-Y') }}</span>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">Received with thanks from </div>
        <div class="col b-b">
            {{ strtoupper($receipt->admission->student->{$parent . '_name'}) }}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">on behalf of </div>
        <div class="col b-b">
            {{ strtoupper($receipt->admission->student->name) }}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">Sum of Rs in Digits. </div>
        <div class="col-md-2 b-b">
            {{ $receipt->amount }} ₹
        </div>
        <div class="col pl-5">In Words (₹): &nbsp;&nbsp;&nbsp; (<span
                class='b-b w-100 px-2'>{{ strtoupper(inr_format($receipt->amount)) }} </span>
            )</div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            Via <div class='ml-4 b-b d-inline-block'>
                {{ strtoupper(\App\Models\Receipt::PAYMENT_MODES[$receipt->payment_mode]) }}</div>
        </div>
        @if ($receipt->payment_mode != 'c')
            <div class="col-6 pl-5">
                <strong>{{ $receipt->payment_mode == 'b' ? 'Cheque' : 'Transaction' }} No.: </strong>
                <div class='ml-4 b-b w-50 d-inline-block'> {{ $receipt->transaction_no }} </div>
            </div>
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
