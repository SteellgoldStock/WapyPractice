<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\level\Position;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\Wapy;

class InstantTeleportTask extends Task {
    private $player;
    private $x;
    private $y;
    private $z;
    private $world;

    public function __construct(string $player, int $x, int $y, int $z, string $world){
        $this->player = $player;
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->world = $world;
    }

    public function onRun(int $currentTick){
        $p = Server::getInstance()->getPlayer($this->player);
        if($p instanceof WAPlayer){
            $p->teleport(new Position($this->x,$this->y,$this->z,Server::getInstance()->getLevelByName($this->world)));
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else{
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}