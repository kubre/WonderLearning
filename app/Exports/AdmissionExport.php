<?php

namespace App\Exports;

use App\Models\Admission;
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

class AdmissionExport extends FromToExportable implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{

    public string $column = 'admission_at';

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new Admission)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            Admission::query()
                ->withoutGlobalScopes()
                ->with('student.school')
        );
    }


    /** @param Admission $admission */
    public function map($admission): array
    {
        return [
            $admission->student->prn,
            config('app.url') . $admission->student->photo,
            /* C */ Date::dateTimeToExcel($admission->admission_at),
            $admission->student->name,
            $admission->student->gender,
            /* F */ Date::dateTimeToExcel($admission->student->dob_at),
            $admission->student->nationality,
            $admission->program,
            $admission->student->father_name,
            $admission->student->father_email,
            $admission->student->father_contact,
            $admission->student->father_occupation,
            $admission->student->father_organization_name,
            $admission->student->mother_name,
            $admission->student->mother_email,
            $admission->student->mother_contact,
            $admission->student->mother_occupation,
            $admission->student->mother_organization_name,
            $admission->student->address,
            $admission->student->city,
            $admission->student->state,
            $admission->student->postal_code,
            $admission->discount,
            $admission->batch,
            $admission->is_transportation_required ? "Yes" : "No",
            $admission->assigned_kit ? "Yes" : "No",
            $admission->student->siblings,
            $admission->student->school->name,
            $admission->student->school->code,
            /* AD */ Date::dateTimeToExcel($admission->created_at),
            /* AE */ Date::dateTimeToExcel($admission->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'PRN',
            'Photo',
            'Admission Date',
            'Name',
            'Gender',
            'Date Of Birth',
            'Nationality',
            'Programme',
            'Father Name',
            'Father Email',
            'Father Contact',
            'Father Occupation',
            'Father Organization',
            'Mother Name',
            'Mother Email',
            'Mother Contact',
            'Mother Occupation',
            'Mother Organization',
            'Address',
            'City',
            'State',
            'Pin Code',
            'Discount',
            'Batch',
            'Transportation Required',
            'Has kit been assigned',
            'Siblings',
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
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'AD' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'AE' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
