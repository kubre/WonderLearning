<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('working_date')) {
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

if (!function_exists('get_academic_year')) {
    function get_academic_year(\Carbon\Carbon $date = null): array
    {
        if (is_null($date)) return working_year();

        $academic_year = optional(session('school'))->academic_year
            ?? (new App\Models\School)->academic_year;
        $start_at = clone $date;
        $start_at
            ->setMonth((int)substr($academic_year, 3, 2))
            ->setDay((int)substr($academic_year, 0, 2));
        $end_at = clone $date;
        $end_at->addYear()
            ->setMonth((int)substr($academic_year, -2))
            ->setDay((int)substr($academic_year, -5, 2));

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

if (!function_exists('is_academic_year_in_sync')) {
    function is_academic_year_in_sync(string $academic_year): string
    {
        $working_year = working_year();
        list($last_year, $current_year) = $working_year;
        return $academic_year === "{$last_year->format('m-y')}|{$current_year->format('m-y')}";
    }
}


if (!function_exists('school')) {
    /** @return App\Models\School */
    function school(): App\Models\School
    {
        return session('school') ?? new App\Models\School;
    }
}

if (!function_exists('money_format_in')) {
    function inr_format($number)
    {
        $no = floor($number);
        // $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        // $points = ($point) ?
        //     "." . $words[$point / 10] . " " .
        //     $words[$point = $point % 10] : '';
        return $result;
    }
}

if (!function_exists('days_in_month')) {
    /*
    * days_in_month($month, $year)
    * Returns the number of days in a given month and year, taking into account leap years.
    *
    * $month: numeric month (integers 1-12)
    * $year: numeric year (any integer)
    *
    * Prec: $month is an integer between 1 and 12, inclusive, and $year is an integer.
    * Post: none
    */
    function days_in_month($month, $year)
    {
        // calculate number of days in a month
        return $month == 2 ?
            ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29)))
            : (($month - 1) % 7 % 2 ? 30 : 31);
    }
}


if (!function_exists('get_months')) {
    /*
    * Get valid month list ex. Jun-2020, Jul-2020 to May-2021
    */
    function get_months(array $academicYear): array
    {
        $monthList = [];
        list($start, $end) = $academicYear;
        $startMonth = $start->copy();
        $endMonth = $end->copy();

        for ($i = $startMonth; $i <= $endMonth; $i->addMonth()) {
            $monthList[$i->format('d-M-Y')] = $i->format('M Y');
        }

        return $monthList;
    }
}
