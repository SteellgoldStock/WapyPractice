<?php

namespace UnknowG\WapyPractice\data;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\utils\Cosmetics;
use UnknowG\WapyPractice\utils\Country;

class Gambler{
    /**
     * @param string $name
     * @return array
     */
    public static function get(string $name) : array
    {
        $my = MySQL::getData();

        $gambler = mysqli_fetch_row($my->query("SELECT * FROM gambler WHERE name = '"  . $name . "'"));
        $my->close();
        return is_null($gambler) ? [$name, "en", "PLAYER",0,0,0,0,0,0,1,1,1,0] : $gambler;
    }

    /**
     * @param string $name
     * @return array
     */
    public static function friendsGet(string $name) : array
    {
        $my = MySQL::getData();

        $gambler = mysqli_fetch_row($my->query("SELECT * FROM friends WHERE name = '"  . $name . "'"));
        $my->close();
        return is_null($gambler) ? [$name, null] : $gambler;
    }

    /**
     * @param string $name
     * @return array
     */
    public static function cosmeticsGet(string $name) : array
    {
        $my = MySQL::getData();

        $gambler = mysqli_fetch_row($my->query("SELECT * FROM cosmetics WHERE name = '"  . $name . "'"));
        $my->close();
        return is_null($gambler) ? [$name, null] : $gambler;
    }

    public static function setDefaultData(WAPlayer $player): bool
    {
        $name = $player->getName();
        $country = Country::getCountry($player->getAddress());

        if (!self::exists($name)) {
            MySQL::sendDB("INSERT INTO gambler (name,lang,rank,rank_expire,league_points,boosters,xp_pass,level_pass,`key`,setting_showOS,setting_receiveMP,setting_receiveFR,setting_fly,setting_animation_lp,setting_timerBoost,subRank,money,setting_combatTip,setting_animationCustom) VALUES ('$name','$country','PLAYER',0,0,0,0,0,0,1,1,1,0,1,1,'PLAYER',0,1,27);");
            MySQL::sendDB("INSERT INTO friends (name, friends) VALUES ('" . $name . "', '-');");
            return true;
        }
        return false;
    }

    public static function edit(string $c, string $v, string $name){
        MySQL::sendDB("UPDATE `gambler` SET `$c`='$v' WHERE name = '".$name."'");
    }

    public static function editOther(string $t, string $c, string $v, string $name){
        MySQL::sendDB("UPDATE `$t` SET `$c`='$v' WHERE name = '".$name."'");
    }

    public static function exists(string $name): bool
    {
        $db = MySQL::getData();

        $res = $db->query("SELECT * FROM gambler WHERE name = '" . $name . "'");
        $db->close();
        return $res->num_rows > 0 ? true : false;
    }

    public static function getRank(string $name): string{
        $data = self::get($name);
        return $data[2];
    }

    public static function getSubRank(string $name): string{
        $data = self::get($name);
        return $data[15];
    }

    public static function getMoney(string $name): string{
        $data = self::get($name);
        return $data[16];
    }

    public static function getLang(string $name): string{
        $data = self::get($name);
        return $data[1];
    }

    public static function getFriends(string $name): string{
        $data = self::friendsGet($name);
        return $data[1];
    }

    public static function getLeaguePoint(string $name): int{
        $data = self::get($name);
        return $data[4];
    }

    public static function getRankExpiration(string $name): int{
        $data = self::get($name);
        return $data[3];
    }

    public static function getSettings(String $parameterType, String $name) : string {
        $data = self::get($name);
        return $data[WAPlayer::SETTINGS[$parameterType]];
    }

    public static function getCosmetics(String $id, String $name){
        $data = self::cosmeticsGet($name);
        return $data[Cosmetics::IDS[$id]];
    }
}