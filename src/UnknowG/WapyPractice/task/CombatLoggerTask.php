<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\modules\CombatLogger;
use UnknowG\WapyPractice\Wapy;

class CombatLoggerTask extends Task{
    public $player;

    public function __construct(WAPlayer $player){
        $this->player = $player;
    }

    public function onRun(int $currentTick){
        if(CombatLogger::$data[$this->player->getName()] >= time()){
            if($this->player->getSettings("COMBAT_TIP") == 1){
                $this->player->sendTip(str_replace("{SECONDS}",CombatLogger::getTime($this->player),$this->player->translate("END_COMBAT")));
            }
        }else{
            CombatLogger::delCombat($this->player);
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}