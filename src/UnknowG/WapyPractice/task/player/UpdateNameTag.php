<?php

namespace UnknowG\WapyPractice\task\player;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;

class UpdateNameTag extends AsyncTask{
    public function onRun(){

    }

    public function onCompletion(Server $server){
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            if(!$player instanceof WAPlayer) return;
            $os = $player->showOs() . " -";
            $player->setNameTag($player->getName() . "\n $os §c".round($player->getHealth()). "§l/§r§c". round($player->getMaxHealth())." ");
        }
    }
}