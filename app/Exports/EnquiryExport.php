<?php

namespace App\Exports;

use App\Models\Enquiry;
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

class EnquiryExport extends FromToExportable implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new Enquiry)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            Enquiry::query()
                ->withoutGlobalScopes()
                ->with('school')
        );
    }


    /** @param Enquiry $enquiry */
    public function map($enquiry): array
    {
        return [
            $enquiry->name,
            $enquiry->gender,
            Date::dateTimeToExcel($enquiry->dob_at),
            $enquiry->program,
            $enquiry->enquirer_name,
            $enquiry->enquirer_email,
            $enquiry->enquirer_contact,
            $enquiry->locality,
            $enquiry->reference,
            Date::dateTimeToExcel($enquiry->follow_up_at),
            $enquiry->school->name,
            $enquiry->school->code,
            Date::dateTimeToExcel($enquiry->created_at),
            Date::dateTimeToExcel($enquiry->updated_at)
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Gender',
            'Date Of Birth',
            'Program',
            'Enquirer Name',
            'Enquirer Email',
            'Enquirer Contact',
            'Locality',
            'Reference',
            'Follow Up Date',
            'School Name',
            'School Code',
            'Academic Year Start',
            'Last Updated',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
