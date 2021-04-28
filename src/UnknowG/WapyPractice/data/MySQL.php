<?php

namespace UnknowG\WapyPractice\data;

use UnknowG\WapyPractice\task\DBAsyncTask;
use UnknowG\WapyPractice\utils\User;
use UnknowG\WapyPractice\Wapy;

class MySQL
{
    /**
     * @return \mysqli
     */
    public static function getData(): \mysqli{
        return new \mysqli('127.0.0.1', 'gaetane', User::DB_PASSWORD, 'gaetane');
    }

    public static function sendDB(string $text): void{
        Wapy::getInstance()->getServer()->getAsyncPool()->submitTask(new DBAsyncTask($text));
    }

    public static function init(): void
    {
        $db = MySQL::getData();
        $db->query("CREATE TABLE IF NOT EXISTS gambler (name TEXT, lang TEXT, `rank` TEXT, `rank_expire` TEXT, `league_points` TEXT, `boosters` INT, `xp_pass` INT, `level_pass` INT, `key` INT, `setting_showOS` INT, `setting_receiveMP` INT, `setting_receiveFR` INT);");
        $db->query("CREATE TABLE IF NOT EXISTS friends (name TEXT, friends LONGTEXT);");
        $db->close();
    }
}
