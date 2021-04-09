<div class='d-block bg-white rounded shadow-sm mb-3 py-4 px-4'>
    <span class="text-muted">
        NOTE: Only school fees receipts can be seen here. For all the other receipts check out fees receipt generation
        section.
    </span>
    <div class="row py-2">
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Stduent Name: </strong>
            <span class="col-6">{{ $admission->student->name }}</span>
        </div>
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Program: </strong>
            <span class="col-6">{{ $admission->program }}</span>
        </div>
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Invoice No: </strong>
            <span class="col-6">{{ $admission->invoice_no }}</span>
        </div>
    </div>
    <div class="row mt-3 py-2">
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Total Amount: </strong>
            <code class="col-6">₹ {{ $admission->total_fees }}</code>
        </div>
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Amount Received: </strong>
            <code class="col-6">₹ {{ $admission->paid_fees }}</code>
        </div>
        <div class="col-md-4 row">
            <strong class="col-6 text-right">Balance Amount: </strong>
            <code class="col-6">₹ {{ $admission->balance_amount ?: 'Nil' }}</code>
        </div>
    </div>
</div>
