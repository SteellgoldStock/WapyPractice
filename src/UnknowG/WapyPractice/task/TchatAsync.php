<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\managers\Text;

class TchatAsync extends AsyncTask{

    public $player;
    public $message;

    public function __construct(String $player, String $message){
        $this->player = $player;
        $this->message = $message;
    }

    public function onRun(){}

    public function onCompletion(Server $server){
        $sender = Server::getInstance()->getPlayer($this->player);
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            if($player instanceof WAPlayer AND $sender instanceof WAPlayer){
                if($player->getLevel()->getName() == $sender->getLevel()->getName()){
                    $message = str_replace(
                        array("{PC}","{SC}","{KILLS}","{DEATHS}","{name}","{msg}","{LEAGUE}","{KD}","{rank}","{OS}"),
                        array(
                            Ranks::$ranks[$sender->getRank()]["colors"]["primary"],
                            Ranks::$ranks[$sender->getRank()]["colors"]["secondary"],
                            $player->gameStats["kills"],
                            $player->gameStats["deaths"],
                            $sender->getName(),
                            $this->message,
                            $player->getLeague(),
                            $player->getRatio(),
                            Ranks::$ranks[$sender->getRank()]["name"][$player->getLang()],
                            $sender->showOs()
                        ),
                        Text::FORMATS[$sender->ingame]
                    );

                    $player->sendMessage($message);
                }
            }
        }
    }
}