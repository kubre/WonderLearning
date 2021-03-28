<?php

namespace App\Models\Traits;

use Carbon\Carbon;
/**
 * 
 */
trait HasAcademicYear
{
    /**
     * Returns the academic year for given date
     *
     * @param Carbon $date
     * @return array
     */
    public function getAcademicYear(Carbon $date = null): array
    {
        return get_academic_year($date);
    }

    public function getAcademicYearFormatted(?array $academic_year = null): string
    {
        return get_academic_year_formatted($academic_year);
    }
}
