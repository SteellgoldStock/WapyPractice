<?php

namespace UnknowG\WapyPractice\task\games;

use pocketmine\level\Level;
use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\games\SumoManager;
use UnknowG\WapyPractice\Wapy;

class GameIsFull extends Task{
    public $world;
    public $red;
    public $blue;

    public static $cancel = false;

    public function __construct(Level $world, WAPlayer $red, WAPlayer $blue){
        $this->world = $world;
        $this->red = $red;
        $this->blue = $blue;
    }

    public function onRun(int $currentTick){
        if(GameIsFull::$cancel == true){
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            return;
        }

        if (count($this->world->getPlayers()) == 2) {
            return;
        }

        if ($this->red instanceof WAPlayer) {
            if ($this->red->getLevel()->getName() !== $this->world->getName()) {
                SumoManager::win($this->blue, $this->red);
                Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                return;
            }
        }else{
            SumoManager::win($this->blue, $this->red);
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            return;
        }

        if ($this->blue instanceof WAPlayer) {
            if ($this->blue->getLevel()->getName() !== $this->world->getName()) {
                SumoManager::win($this->red, $this->blue);
                Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                return;
            }
        }else{
            SumoManager::win($this->red, $this->blue);
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            return;
        }
    }
}