<?php

namespace UnknowG\WapyPractice\utils;

class User{

    const OS_LIST = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows 10", "Windows", "Dedicated", "Orbis", "Playstation 4", "Nintento Switch", "Xbox One"];
    const UI = ["Classic UI", "Pocket UI"];
    const CONTROLS = ["Unknown", "Mouse", "Touch", "Controller"];
    const GUI = [-2 => "Minimum", -1 => "Medium", 0 => "Maximum"];

    const FORMATED_LIST = [
        "VIP"=>[
            "BACK"=>2000,
            "NAME"=> [
                "fr"=>"Grade VIP",
                "en"=>"Rank VIP",
            ]
        ],
        "VIP_PLUS"=>[
            "BACK"=>3000,
            "NAME"=> [
                "fr"=>"Grade VIP+",
                "en"=>"Rank VIP+",
            ]
        ],
        "PREMIUM"=>[
            "BACK"=>5000,
            "NAME"=> [
                "fr"=>"Grade Premium",
                "en"=>"Rank Premium",
            ]
        ]
    ];

    const DB_PASSWORD = "v5yX46muJ78Wq9V8MNk6Yq";

    public static function returnInt(bool $o): string{
        if($o == true){
            return "1";
        }else{
            return "0";
        }
    }
}