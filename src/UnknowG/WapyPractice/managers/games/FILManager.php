<?php

namespace UnknowG\WapyPractice\managers\games;

use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\utils\Color;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\utils\Positions;

class FILManager{
    public static function addPlayer(WAPlayer $player){
        $world = Server::getInstance()->getLevelByName("FIL_1");
        $rand = mt_rand(1,3);

        $player->setGamemode(0);
        $player->giveInventory("fil");
        $player->teleport(new Position(Positions::FIL_SPAWNPOINT[$rand]["x"],Positions::FIL_SPAWNPOINT[$rand]["y"],Positions::FIL_SPAWNPOINT[$rand]["z"],$world));
    }

    public static function getPlayers() : int {
        return count(Server::getInstance()->getLevelByName("FIL_1")->getPlayers()) + count(Server::getInstance()->getLevelByName("FIL_2")->getPlayers());
    }
}