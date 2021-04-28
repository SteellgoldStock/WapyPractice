<?php

namespace UnknowG\WapyPractice\managers\games;

use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\MySQL;
use UnknowG\WapyPractice\utils\Positions;

class GappleManager{
    public static function addPlayer(WAPlayer $player, $ranked){
        $r = mt_rand(1,4);
        if($ranked == true){
            $player->ingame = "GAPPLE_RANKED";
        }else{
            $player->ingame = "GAPPLE";
        }

        $player->giveInventory("gapple");
        $world = Server::getInstance()->getLevelByName("gapple");
        $player->teleport(new Position(Positions::GAPPLE_SPAWNPOINT[$r]["x"],Positions::GAPPLE_SPAWNPOINT[$r]["y"],Positions::GAPPLE_SPAWNPOINT[$r]["z"],$world));

        $player->gameStats["kills"] = 0;
        $player->gameStats["deaths"] = 0;
        $player->gameStats["lpoints"] = 0;
    }

    public static function addPoint(WAPlayer $player){
        $p = $player->getLeaguePoints();
        $pToAdd = $p + 1;
        MySQL::sendDB("UPDATE `gambler` SET `league_points`='$pToAdd' WHERE name = '".$player->getName()."'");
    }

    public static function delPoint(WAPlayer $player){
        $p = $player->getLeaguePoints();
        if($p == 0){
            Server::getInstance()->getLogger()->alert("Cancel successfull to remove a league point, the player don't have point to remove");
            return;
        }

        $pToAdd = $p - 1;
        MySQL::sendDB("UPDATE `gambler` SET `league_points`='$pToAdd' WHERE name = '".$player->getName()."'");
    }

    public static function getPlayers(String $world) : int {
        return count(Server::getInstance()->getLevelByName($world)->getPlayers());
    }
}