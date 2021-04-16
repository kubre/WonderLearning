<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport extends FromToExportable implements FromQuery, WithHeadings, ShouldAutoSize
{

    public function __construct(?string $from_date, ?string $to_date)
    {
        parent::__construct((new User)->getTable(), $from_date, $to_date);
    }

    public function query(): Builder
    {
        return $this->applyFromToOn(
            User::query()
                ->leftJoin('schools', 'schools.id', '=', 'users.school_id')
                ->select([
                    'users.id', 'users.name', 'users.email',
                    'schools.name as school_name', 'users.created_at', 'users.updated_at',
                ])
        );
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'Name',
            'Email',
            'School',
            'Created',
            'Last Updated',
        ];
    }
}
