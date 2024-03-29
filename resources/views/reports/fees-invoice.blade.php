<div id="print-report" class="bg-white px-4 py-4">
    <div class="row">
        <div class="col-3">
            <img style="max-height: 100px; width: auto;" src="{{ $admission->student->school->logo }}" alt="Logo">
        </div>
        <div class="col-3 text-center pl-5 mt-3">
            <h2>
                <strong>Invoice</strong>
            </h2>
        </div>
        <div class="col">
            <table class="w-100 table table-bordered table-black">
                <tr>
                    <th>Center Head</th>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $admission->student->school->address }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $admission->student->school->contact }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <span class='col'>
            <span>PRN: </span>
            <strong>{{ $admission->student->prn }}</strong>
        </span>
    </div>

    <div class="row mt-5">
        <div class="col-6">
            <table class="w-100 table table-bordered">
                <tr>
                    <th>Student Name</th>
                    <td>{{ $admission->student->name }}</td>
                </tr>
                <tr>
                    <th>Parent Name</th>
                    <td>{{ $admission->student->{$parent . '_name'} }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $admission->student->address }}</td>
                </tr>
                <tr>
                    <th>Admitted to</th>
                    <td>{{ $admission->program }}</td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="w-100 table table-bordered">
                <tr>
                    <th>Admission Month</th>
                    <td>{{ $admission->admission_at->format('M-y') }}</td>
                </tr>
                <tr>
                    <th>Invoice Number</th>
                    <td>{{ $admission->invoice_no }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $admission->admission_at->format('d - M - y') }}</td>
                </tr>
                <tr>
                    <th>Batch</th>
                    <td>{{ $admission->batch }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row mt-5 px-3">
        <table class="table table-bordered table-black col">
            <thead>
                <tr>
                    <th colspan="2">Fees for year {{ get_academic_year_formatted(working_year()) }}</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admission->student->school->fees->{$admission->fees_column} as $fees)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <th>{{ $fees['fees'] }}</th>
                        <td class='text-right'>{{ $fees['amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th colspan="2">Total</th>
                <th class="text-right">{{ $admission->student->school->fees->{$admission->fees_total_column} }}</th>
            </tfoot>
        </table>
    </div>

    <div class="row mt-3" style="border: 1x solid black">
        <span class='col'>
            <span>Amount Chargable (in words): </span>
            <strong class="b-b">
                {{ strtoupper(inr_format($admission->student->school->fees->{$admission->fees_total_column})) }}
                RUPEES ONLY
                /-
            </strong>
        </span>
    </div>

    <div class="row mt-3">
        <strong class="col">For {{ auth()->user()->name }}</strong>
    </div>
    <div class="row mt-5">
        <strong class="col">Authorised Signatory</strong>
        <strong class="col text-right">Receiver's Signature</strong>
    </div>
</div>
