<div id="print-report" class="new-report bg-white px-4 py-4">
    <div class="row">
        <div class="col-3">
            <img style="max-height: 100px; width: auto;" src="{{ $admission->student->school->logo }}" alt="Logo"><br>
            <strong class="mt-1">{{ $admission->student->school->name }}</strong>
        </div>
        <div class="col-4 text-center mt-3">
            <h2>
                <strong>Declaration Form</strong>
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

    <div class="mt-4">
        <p>I <strong>{{ $admission->student->{$parent . '_name'} ?? '' }}</strong>, being the lawful parent/guardian
            of
            <strong>{{ $admission->student->name }}</strong>, PRN <strong>{{ $admission->student->prn }}</strong>
            studying in Grade
            <strong>{{ $admission->program }}</strong> hereby agree that:
        </p>

        <p>
            <ol>
                <li class='mt-2'>On application, I will pay the registration and assessment fee which covers the cost of
                    processing
                    the admission.</li>

                <li class='mt-2'>I will pay the cost of Student Kit (Consist of text & exercise books, the school
                    planner,
                    magazine
                    and other educational materials) before the commencement of the academic year.</li>

                <li class='mt-2'>It's been discussed and agreed to that I will pay rest of the fees as per the ANNEXURE
                    - A.
                    If I fail to
                    do so, the school has the right to exclude my child from attending school and I will not have any
                    claim in any form [legal/security] against the school.</li>

                <li class='mt-2'>If any cheque issued by me is dishonored, I undertake to remit the fee in cash within
                    five
                    calendar
                    days of the date of notice, failing which the school has the right to exclude my child from
                    attending
                    school. I will also pay a fine of RS. 250/- for each cheque dishonored apart from the applicable
                    late
                    fee.</li>

                <li class='mt-2'>On default of payment of fees / dishonoring of a cheque issued by me, the school can
                    initiate
                    legal proceedings against me to recover the dues with interest, the cost of recovery, and
                    reinstate/recover discounts/concessions granted. All legal charges met by the school will be borne
                    by
                    me.</li>

                <li class='mt-2'>
                    I understand that my child cannot remain on school rolls unless he/she abides by the ethos
                    and prevalent rules of the school.
                </li>
            </ol>
        </p>
    </div>

    <div class="mt-4">
        <h5>Admission Details</h5>
        <div class="row">
            <div class="col-6">
                <table class="w-100 table table-bordered table-black">
                    <tr>
                        <th>Name of Student</th>
                        <td>{{ $admission->student->name }}</td>
                    </tr>
                    <tr>
                        <th>Name of Parent/Guardian</th>
                        <td>{{ $admission->student->{$parent . '_name'} ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Permanent Address</th>
                        <td>{{ $admission->student->address }}</td>
                    </tr>
                    <tr>
                        <th>Phone Numbers</th>
                        <td>{{ \implode('/', [$admission->student->father_contact, $admission->student->mother_contact]) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table table-bordered table-black">
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

    </div>

    <div class="mt-1">
        <h5>Fees Structure</h5>
        <table class="table table-bordered table-black col">
            <thead>
                <tr>
                    <th colspan="2">Fees Strcuture for year
                        {{ $admission->program }} ({{ get_academic_year_formatted(working_year()) }})</th>
                    <th class="text-end text-right">Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admission->student->school->fees->{$admission->fees_column} as $fees)
                <tr>
                    <td style="width: 14.5%">{{ $loop->iteration }}</td>
                    <th>{{ $fees['fees'] }}</th>
                    <td class='text-right text-end'>{{ $fees['amount'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th class="text-right text-end">
                        {{ $admission->student->school->fees->{$admission->fees_total_column} }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="bg-white">
        <h5>Fees Installments (ANNEXURE - A)</h5>
        <table class="table table-bordered table-black">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Due Month</th>
                    <th style="text-align: right">Total Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admission->installments as $installment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $monthList[$installment->month] }}</td>
                    <td style="text-align: right">
                        {{ $installment->amount }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="2">Discount Given (if any)</th>
                    <th style="text-align: right">
                        {{ $admission->discount === 0 ? 'N/A' : $admission->discount }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2">Total</th>
                    <th style="text-align: right">{{ $admission->installments->sum('amount') }}</th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row mt-3" style="border: 1x solid black">
        <span class='col'>
            <span>Fees Payable (in words): </span>
            <strong class="b-b">
                {{ \strtoupper(inr_format($admission->installments->sum('amount'))) }}
                RUPEES ONLY
                /-
            </strong>
        </span>
    </div>
    <div style="min-height: 50px"></div>
    <div class="row mt-5">
        <strong class="col text-end text-right">
            Parent Signature<br>({{ now()->format('d-M-Y') }}&nbsp;&nbsp;&nbsp;)
        </strong>
    </div>
</div>