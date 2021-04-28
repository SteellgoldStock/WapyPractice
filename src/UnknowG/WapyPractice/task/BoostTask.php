<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\api\Sound;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\Wapy;

class BoostTask extends Task{

    public $time;
    public $player;

    public function __construct(WAPlayer $player, $time){
        $this->player = $player;
        $this->time = $time;
    }

    public function onRun(int $currentTick){
        if($this->player->isOnline()){
            $sec = $this->time - time();

            if($sec <= 0){
                $this->player->sendMessage(str_replace("{XP}",$this->player->xpWithBoost,$this->player->translate("BOOST_ENDING_RECAP")));
                $this->player->disableBoost();
                Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                return;
            }

            if($sec <= 10){
                $this->player->sendTitle(" §d§l» Booster d'XP «","§d".$this->player->translate("END_IN")." ".$sec . " " . $this->player->translate("SECOND"));
                $s = new Sound();
                $s->sendSound($this->player,"note.harp");
                return;
            }

            if($this->player->getSettings("TIMER_BOOST") == 1){
                $this->player->sendTip(Text::PREFIX_BOOST . str_replace("{TIME}",$sec,$this->player->translate("BOOST_END")). Text::PREFIX_REVERSED_BOOST);
            }
        }else{
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}