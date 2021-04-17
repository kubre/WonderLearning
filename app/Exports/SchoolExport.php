<?php

namespace App\Exports;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SchoolExport extends FromToExportable implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithColumnFormatting
{

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new School)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            School::query()
        );
    }


    public function headings(): array
    {
        return [
            'Unique ID',
            'Name',
            'Logo',
            'Contact',
            'Email',
            'Address',
            'Login URL',
            'Code',
            'Academic Year',
            'Account Suspend',
            'Created',
            'Last Updated'
        ];
    }

    /** @param School $school */
    public function map($school): array
    {
        return [
            $school->id,
            $school->name,
            config('app.url') . $school->logo,
            $school->contact,
            $school->email,
            $school->address,
            config('app.url') . '/login/' . $school->login_url,
            $school->code,
            $school->academic_year,
            is_null($school->suspended_at) ? "No" : "Yes",
            Date::dateTimeToExcel($school->created_at),
            Date::dateTimeToExcel($school->updated_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
