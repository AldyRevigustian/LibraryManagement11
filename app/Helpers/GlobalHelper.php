<?php

use Carbon\Carbon;

if (!function_exists('convertDateToMysqlFormat')) {
    function convertDateToMysqlFormat($dateString)
    {
        $date = Carbon::createFromFormat('d/m/Y', $dateString);
        $now = Carbon::now();
        $date->setTime($now->hour, $now->minute, $now->second);
        return $date->format('Y-m-d');
    }
}
