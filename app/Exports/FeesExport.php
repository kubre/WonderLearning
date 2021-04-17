<?php

namespace App\Exports;

use App\Models\Fees;
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

class FeesExport extends FromToExportable implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting
{
    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new Fees)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(Fees::query()
            ->withoutGlobalScopes()
            ->with('school'));
    }


    /** @param Fees $fees */
    public function map($fees): array
    {
        return [
            $fees->id,
            $fees->school->name,
            $fees->school->code,
            $fees->title,
            $fees->playgroup_total,
            $fees->nursery_total,
            $fees->junior_kg_total,
            $fees->senior_kg_total,
            Date::dateTimeToExcel($fees->created_at),
            Date::dateTimeToExcel($fees->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'School Name',
            'School Code',
            'Title',
            'Playgroup',
            'Nursery',
            'Junior KG',
            'Senior KG',
            'Academic Year Start',
            'Last Updated',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
