<?php

namespace UnknowG\WapyPractice\task\player;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\Gambler;

class PlayerRegistering extends AsyncTask{
    private $name;

    public function __construct(String $name){
        $this->name = $name;
    }

    public function onRun(){}

    public function onCompletion(Server $server){
        $player = $server->getPlayer($this->name);
        if($player instanceof WAPlayer AND $player->isOnline()){
            $player->sendMessage($player->translate("PLAYER_JOIN"));

            Gambler::setDefaultData($player);
        }
    }
}