<?php

namespace App\Helpers;

class GenerateFakerSaleId
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public static function createRandomDate($year, $month)
    {
        $day = mt_rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
        $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

        return new static($date);
    }

    public function format($format)
    {
        return date($format, strtotime($this->date));
    }
}
