<?php

namespace UnknowG\WapyPractice\api;

class Time{
    public static $cooldown = [];
    public static $enderpearl = [];

    public static function getMicroTime() : int{
        $mt = explode(' ', microtime()) ;
        $mt = ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
        return $mt;
    }

    public static function convertWithday(int $int){
        $init = $int - time();
        $hours = floor(($init / 3600));
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;
        $day = floor($init / 86400);

        return ["d" => $day, "h" => $hours, "m" => $minutes, "s" => $seconds];
    }
}