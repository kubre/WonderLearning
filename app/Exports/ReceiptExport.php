<?php

namespace App\Exports;

use App\Models\Receipt;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    ShouldAutoSize,
    WithColumnFormatting,
    WithHeadings,
    WithMapping,
};
use PhpOffice\PhpSpreadsheet\{
    Shared\Date,
    Style\NumberFormat,
};

class ReceiptExport extends FromToExportable implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{

    public string $column = 'receipt_at';

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new Receipt)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            Receipt::query()
                ->withTrashed()
                ->withoutGlobalScopes()
                ->with('admission.student.school')
        );
    }


    /** @param Receipt $receipt */
    public function map($receipt): array
    {
        return [
            $receipt->id,
            $receipt->admission->student->school->name,
            $receipt->admission->student->school->code,
            $receipt->admission->student->prn,
            $receipt->receipt_no,
            $receipt->receipt_at,
            $receipt->amount,
            $receipt->for,
            $receipt->mode,
            $receipt->bank_name,
            $receipt->bank_branch,
            $receipt->transaction_no,
            $receipt->paid_at,
            is_null($receipt->deleted_at) ? "Yes" : "No",
            Date::dateTimeToExcel($receipt->created_at),
            Date::dateTimeToExcel($receipt->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'School Name',
            'School Code',
            'Student PRN',
            'Receipt No',
            'Receipt Date',
            'Amount',
            'For',
            'Payment Mode',
            'Bank Name',
            'Bank Branch',
            'Cheque/Transaction No',
            'Cheque/Online Pay Date',
            "Is Canceled",
            'Academic Year Start',
            'Last Updated',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'O' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
