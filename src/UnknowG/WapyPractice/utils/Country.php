<?php

namespace UnknowG\WapyPractice\utils;

class Country{
    public static function getCountry(string $ip) : string{
        $query = @unserialize(file_get_contents("http://ip-api.com/php/". $ip));
        if ($query["status"] === "success") {
            $cc = strtolower($query["countryCode"]);
            if (in_array($cc, array("en","us"))) {
                return "en";
            } else if (in_array($cc, array("fr","be","lu","ca","ch"))) {
                return "fr";
            } else if (in_array($cc, array("es","br","me"))) {
                return "es";
            } else if (in_array($cc, array("de"))) {
                return "de";
            }
        }
        return "en";
    }
}