<?php

namespace UnknowG\WapyPractice\task\games;

use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\Wapy;

class SumoLaunchTask extends Task {

    public $red;
    public $blue;
    public $effect;
    public $time;

    /**
     * SumoLaunchTask constructor.
     * @param WAPlayer $red
     * @param WAPlayer $blue
     * @param int $effect
     * @param int $time
     */
    public function __construct(WAPlayer $red, WAPlayer $blue, int $effect, Int $time){
        $this->red = $red;
        $this->blue = $blue;
        $this->effect = $effect;
        $this->time = $time;
    }

    public function onRun(int $currentTick){
        $time = $this->time - time();

        if($time <= 0){
            $this->blue->setImmobile(false);
            $this->red->setImmobile(false);
            $this->blue->sendScreenAnimation(5);
            $this->red->sendScreenAnimation(5);
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }

        $this->red->sendTitle($time);
        $this->blue->sendTitle($time);
    }
}