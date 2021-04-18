<?php

namespace App\Exports;

use App\Models\KitStock;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    ShouldAutoSize,
    WithColumnFormatting,
    WithHeadings,
    WithMapping,
    WithStrictNullComparison,
};
use PhpOffice\PhpSpreadsheet\{
    Shared\Date,
    Style\NumberFormat,
};

class KitStockExport extends FromToExportable implements
    FromQuery,
    ShouldAutoSize,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithStrictNullComparison
{

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new KitStock)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            KitStock::query()
                ->withoutGlobalScopes()
                ->with('school')
        );
    }


    /** @param KitStock $kit */
    public function map($kit): array
    {
        return [
            $kit->id,
            $kit->school->name,
            $kit->school->code,
            $kit->playgroup_total,
            $kit->playgroup_assigned,
            $kit->playgroup_total - $kit->playgroup_assigned,
            $kit->nursery_total,
            $kit->nursery_assigned,
            $kit->nursery_total - $kit->nursery_assigned,
            $kit->junior_kg_total,
            $kit->junior_kg_assigned,
            $kit->junior_kg_total - $kit->junior_kg_assigned,
            $kit->senior_kg_total,
            $kit->senior_kg_assigned,
            $kit->senior_kg_total - $kit->senior_kg_assigned,
            Date::dateTimeToExcel($kit->created_at),
            Date::dateTimeToExcel($kit->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'School Name',
            'School Code',
            'Playgroup Total',
            'Playgroup Assigned',
            'Playgroup Remaining',
            'Nursery Total',
            'Nursery Assigned',
            'Nursery Remaining',
            'Junior KG Total',
            'Junior KG Assigned',
            'Junior KG Remaining',
            'Senior KG Total',
            'Senior KG Assigned',
            'Senior KG Remaining',
            'Academic Year Start',
            'Last Updated',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
