<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use DateTime;

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
    public static function getAcademicYear(Carbon $date = null): array
    {
        if (is_null($date)) $date = Carbon::today();
        
        $last_year = clone $date;
        $last_year->setDay(1)->setMonth(6);
        $current_year = clone $date;
        $current_year->addYear()->setDay(31)->setMonth(5);

        if ($date->isBetween($last_year, $current_year)) {
            return [$last_year, $current_year];
        }

        return [$last_year->subYear(), $current_year->subYear()];
    }

    public static function getAcademicYearFormatted(Carbon $date = null): string
    {
        list($last_year, $current_year) = self::getAcademicYear($date);
        return "{$last_year->format('M y')} - {$current_year->format('M y')}";
    }
}
