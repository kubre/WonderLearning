<div class="shadow bg-white px-2">
    <table class="table table-bordered">
        <tr>
            <th>Sr. No.</th>
            <th>Due Month</th>
            <th style="text-align: right">Total Amount (₹)</th>
            <th style="text-align: right">Due Amount (₹)</th>
        </tr>
        @foreach ($installments as $installment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $installment->month_name_and_year }}</td>
                <td style="text-align: right">
                    {{ $installment->amount }}</td>
                <td style="text-align: right">{{ $installment->due_amount ?: 'Nil' }}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th style="text-align: right">{{ $installments->sum('amount') }}</th>
                <th style="text-align: right">{{ $installments->sum('due_amount') ?: 'Nil' }}</th>
            </tr>
        </tfoot>
    </table>
</div>
