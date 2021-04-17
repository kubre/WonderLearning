<?php

namespace App\Exports;

use App\Models\User;
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

class UsersExport extends FromToExportable implements
    FromQuery,
    WithHeadings,
    ShouldAutoSize,
    WithMapping,
    WithColumnFormatting
{

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new User)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            User::query()
                ->with('roles', 'school')
        );
    }

    /** @param User $user */
    public function map($user): array
    {
        return [
            $user->id,
            optional($user->school)->name,
            optional($user->school)->code,
            $user->name,
            $user->email,
            $user->roles->pluck('name')->join(', '),
            Date::dateTimeToExcel($user->created_at),
            Date::dateTimeToExcel($user->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'School Name',
            'School Code',
            'Name',
            'Email',
            'Roles',
            'Creation Date',
            'Last Updated',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
