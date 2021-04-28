<?php

namespace UnknowG\WapyPractice\commands\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Ranks;

class RankExpirationCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if($player instanceof WAPlayer){
            if(isset($args[0])){
                $toCheck = $args[0];
            }else{
                $toCheck = $player->getName();
            }

            $t = Server::getInstance()->getPlayer($toCheck);
            if($t instanceof WAPlayer){
                if($t->hasExpirationRank()){
                    $time = $t->getRankExpiration();
                    $player->sendMessage(str_replace(
                        array("{PLAYER}","{RANK}","{DAY}","{HOURS}","{MINUTES}","{SECONDS}"),
                        array($t->getName(),Ranks::$ranks[$t->getRank()]["name"][$player->getLang()],Time::convertWithday($time)["d"],Time::convertWithday($time)["h"],Time::convertWithday($time)["m"],Time::convertWithday($time)["s"]),
                        $player->translate("RANK_EXPIRATION")
                    ));
                }else{
                    $player->sendMessage(str_replace(array("{PLAYER}","{RANK}"),array($t->getName(),Ranks::$ranks[$t->getRank()]["name"][$player->getLang()]),$player->translate("NO_RANK_EXPIRATION")));
                }
            }else{
                $player->sendMessage(str_replace("PLAYER",$args[0],$player->translate("PLAYER_DISCONNECTED")));
            }
        }
    }
}