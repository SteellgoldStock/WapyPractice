<?php

namespace UnknowG\WapyPractice\managers\games;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\utils\Color;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\task\games\GameIsFull;
use UnknowG\WapyPractice\task\games\SumoLaunchTask;
use UnknowG\WapyPractice\task\scoreboard\ScoreboardGame;
use UnknowG\WapyPractice\utils\Positions;
use UnknowG\WapyPractice\Wapy;

class SumoManager{
    public static $sumo1 = 0;
    public static $sumo2 = 0;
    public static $sumo3 = 0;
    public static $sumo4 = 0;
    public static $sumo5 = 0;
    public static $sumo6 = 0;

    public static $waitingList = [
        "sumo1"=>null,
        "sumo2"=>null,
        "sumo3"=>null,
        "sumo4"=>null,
        "sumo5"=>null,
        "sumo6"=>null,
    ];

    public static function getPlayers() : int {
        $s1 = count(Server::getInstance()->getLevelByName("sumo1")->getPlayers());
        $s2 = count(Server::getInstance()->getLevelByName("sumo2")->getPlayers());
        $s3 = count(Server::getInstance()->getLevelByName("sumo3")->getPlayers());
        $s4 = count(Server::getInstance()->getLevelByName("sumo4")->getPlayers());
        $s5 = count(Server::getInstance()->getLevelByName("sumo5")->getPlayers());
        $s6 = count(Server::getInstance()->getLevelByName("sumo6")->getPlayers());
        return ($s1 + $s2 + $s3 + $s4 + $s5  + $s6);
    }

    public static function addWainting(WAPlayer $player, String $levelId, String $strColor){
        $player->ingame = "SUMO";
        $player->sendMessage("Joining");
        self::$waitingList[$levelId][$strColor] = [
            "player" => $player->getName()
        ];
    }

    public static function removeWainting(WAPlayer $player, String $gameId){
        $player->ingame = null;
        $player->sendMessage("Leaving");
        unset(self::$waitingList[$gameId]);
        self::$waitingList[$gameId] = null;
    }

    public static function launchGame(Level $level){
        $game = $level->getName();
        $red = Server::getInstance()->getPlayer(self::$waitingList[$game]["red"]["player"]);
        $blue = Server::getInstance()->getPlayer(self::$waitingList[$game]["blue"]["player"]);

        if($red instanceof WAPlayer AND $blue instanceof WAPlayer){
            $red->teleport(new Position(Positions::SUMO_SPAWNPOINT[$game]["rX"],Positions::SUMO_SPAWNPOINT[$game]["rY"],Positions::SUMO_SPAWNPOINT[$game]["rZ"],$level));
            $blue->teleport(new Position(Positions::SUMO_SPAWNPOINT[$game]["bX"],Positions::SUMO_SPAWNPOINT[$game]["bY"],Positions::SUMO_SPAWNPOINT[$game]["bZ"],$level));
            $red->setImmobile(true);
            $blue->setImmobile(true);
            $red->giveInventory("sumo",new Color(204, 121, 118));
            $blue->giveInventory("sumo",new Color(133, 140, 212));
            Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new SumoLaunchTask($red,$blue,5, time() + 3),20);
            Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardGame($red,false,"sumo1","SUMO"),20 * 3);
            Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardGame($blue,false,"sumo1","SUMO"),20 * 3);
            Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new GameIsFull(Server::getInstance()->getLevelByName("sumo1"),$red,$blue),20 * 3);
        }
    }

    public static function win(WAPlayer $winner, WAPlayer $looser){
        GameIsFull::$cancel = true;

        $winner->addWPXP();
        $winner->ingame = null;
        $winner->sendMessage(str_replace(array("{PLAYER}","{KILLS}","{DEATHS}"),array($looser->getName(),$looser->gameStats["deaths"],$winner->gameStats["deaths"]),$winner->translate("SUMO_WIN")));
        $winner->giveInventory("lobby");
        $winner->teleport(new Position(Positions::SPAWN["x"], Positions::SPAWN["y"], Positions::SPAWN["z"], Server::getInstance()->getLevelByName("lobby")));

        if($looser instanceof WAPlayer){
            $looser->ingame = null;
            $looser->sendMessage(str_replace(array("{PLAYER}","{KILLS}","{DEATHS}"),array($winner->getName(),$looser->gameStats["kills"],$looser->gameStats["deaths"]),$winner->translate("SUMO_LOOSE")));
            $looser->giveInventory("lobby");
            $looser->teleport(new Position(Positions::SPAWN["x"], Positions::SPAWN["y"], Positions::SPAWN["z"], Server::getInstance()->getLevelByName("lobby")));
        }
    }

    public static function checkWinner(WAPlayer $red, WAPlayer $blue, Level $level){
        $rk = $red->gameStats["kills"];
        $bk = $blue->gameStats["kills"];

        if($rk == 5){
            self::win($red,$blue);
            SumoManager::removes($level->getName());
        }elseif($bk == 5){
            self::win($blue,$red);
            SumoManager::removes($level->getName());
        }
    }

    public static function removes(String $id){
        switch ($id){
            case "sumo1":
                self::$sumo1 = 0;
                break;
            case "sumo2":
                self::$sumo2 = 0;
                break;
            case "sumo3":
                self::$sumo3 = 0;
                break;
            case "sumo4":
                self::$sumo4 = 0;
                break;
            case "sumo5":
                self::$sumo5 = 0;
                break;
            case "sumo6":
                self::$sumo6 = 0;
                break;
        }
    }
}