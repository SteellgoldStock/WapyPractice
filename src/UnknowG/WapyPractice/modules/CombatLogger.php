<?php

namespace UnknowG\WapyPractice\modules;

use UnknowG\WapyPractice\base\WAPlayer;

class CombatLogger{
    public static $data = [];

    public static function isInCombat(WAPlayer $player){
        if(array_key_exists($player->getName(),self::$data)){
            return true;
        }else{ return false; }
    }

    public static function setCombat(WAPlayer $player){
        self::$data[$player->getName()] = time() + 10;
    }

    public static function getTime(WAPlayer $player){
        return self::$data[$player->getName()] - time();
    }

    public static function delCombat(WAPlayer $player){
        unset(self::$data[$player->getName()]);
    }
}