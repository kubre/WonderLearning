<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('working_date'))
{
    /**
     * get or set working yar
     *
     * @param null|\Carbon\Carbon $date
     * @return array
     * 
     * @example location To get current working year just call working_year()
     * @example location To set current working year just call working_year(Carbon::today()) with argument date function will calculate * academic year automatically.  
     */
    function working_year(\Carbon\Carbon $date = null): array
    {
        if (!is_null($date)) session(['_working_year' => get_academic_year($date)]); 
        if (!Session::exists('_working_year')) session(['_working_year' => get_academic_year(today())]);
        return session('_working_year');
    }
}

if (!function_exists('get_academic_year'))
{
    function get_academic_year(\Carbon\Carbon $date = null): array
    {
        if (is_null($date)) return working_year();
        
        $start_at = clone $date;
        $start_at->setDay(1)->setMonth(6);
        $end_at = clone $date;
        $end_at->addYear()->setDay(31)->setMonth(5);

        if ($date->isBetween($start_at, $end_at)) {
            return [$start_at, $end_at];
        }

        return [$start_at->subYear(), $end_at->subYear()];
    }
}

if (!function_exists('get_academic_year_formatted')) {
    function get_academic_year_formatted(?array $academic_year = null): string
    {
        if (is_null($academic_year)) $academic_year = working_year();
        list($last_year, $current_year) = $academic_year;
        return "{$last_year->format('M y')} - {$current_year->format('M y')}";
    }
}