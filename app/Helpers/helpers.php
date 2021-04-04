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
