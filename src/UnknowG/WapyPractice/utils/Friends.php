<?php

namespace UnknowG\WapyPractice\utils;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\MySQL;

class Friends{
    public static $requests = [];

    /**
     * @param string $name
     * @return array
     */
    public static function getFriend(string $name){
        $my = MySQL::getData();
        $result = $my->query("SELECT * FROM friends WHERE name = '$name'");
        $data = mysqli_fetch_assoc($result);
        $list = $data["friends"];

        if ($list == "-") {
            $list = [];
        } else {
            $list = explode(",", $list);
        }

        return $list;
    }

    /**
     * @param string $player
     * @param string $friend
     */
    public static function addFriend(string $player, string $friend){
        $players = self::getFriend($player);
        $players[] = $friend;

        $friends = self::getFriend($friend);
        $friends[] = $player;

        self::setFriend($player, $players);
        self::setFriend($friend, $friends);
    }

    /**
     * @param string $player
     * @param string $friend
     */
    public static function delFriend(string $player, string $friend){
        $players = self::getFriend($player);
        $friends = self::getFriend($friend);

        unset($players[array_search($friend, $players)]);
        unset($friends[array_search($player, $friends)]);

        self::setFriend($player, $players);
        self::setFriend($friend, $friends);
    }

    /**
     * @param string $name
     * @param array $array
     */
    public static function setFriend(string $name, array $array){
        $my = MySQL::getData();
        if (count($array) == 0) {
            $friend = "-";
        } else {
            $friend = implode(",", $array);
        }

        $my->query("UPDATE friends SET friends = '" . $friend . "' WHERE name = '" . $name . "'");
        $my->close();
    }

    /**
     * @param string $player
     * @param string $friend
     * @return bool
     */
    public static function isFriend(string $player, string $friend) : bool{
        $my = MySQL::getData();
        $result = mysqli_fetch_row($my->query("SELECT * FROM friends WHERE name = '" . $player . "'"));
        $my->close();
        $list = $result[1];

        if ($list == "-") {
            $list = [];
        } else {
            $list = explode(",", $list);
        }

        if (in_array($friend, $list)){
            return true;
        } else {
            return false;
        }
    }

    public static function sendRequest(WAPlayer $requester, WAPlayer $receiver){
        self::$requests[$receiver->getName()] = $requester->getName();
    }

    public static function acceptRequest(WAPlayer $receiver){
        self::addFriend($receiver->getName(),self::$requests[$receiver->getName()]);
        unset(self::$requests[$receiver->getName()]);
    }

    public static function denyRequest(WAPlayer $receiver){
        unset(self::$requests[$receiver->getName()]);
    }
}