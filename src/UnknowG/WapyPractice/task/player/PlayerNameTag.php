<?php

namespace UnknowG\WapyPractice\task\player;

use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\Wapy;

class PlayerNameTag extends Task{
    public function onRun(int $currentTick){
        Wapy::getInstance()->getServer()->getAsyncPool()->submitTask(new UpdateNameTag());
    }
}