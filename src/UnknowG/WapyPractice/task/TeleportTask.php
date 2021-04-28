<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\entity\Effect;
use pocketmine\level\Position;
use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\api\Sound;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\Wapy;

class TeleportTask extends Task{
    /** @var WAPlayer */
    private $player;

    /** @var Position */
    private $position;

    /** @var int */
    private $timer;

    /** @var int */
    private $px;

    /** @var int */
    private $pz;

    public function __construct(WAPlayer $player, Position $position, int $timer, int $px, int $pz){
        $this->player = $player;
        $this->position = $position;
        $this->timer = $timer;
        $this->px = $px;
        $this->pz = $pz;
    }

    public function onRun(int $currentTick){
        if ($this->player->isOnline()) {
            if ($this->player->canTeleport()) {
                $player = $this->player;
                if (Wapy::getInstance()->getServer()->getPlayer($player->getName()) === false) {
                    Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                }

                $px = round($player->x);
                $pz = round($player->z);
                $x = round($this->px);
                $z = round($this->pz);

                if (($px !== $x) || ($pz !== $z)) {
                    $this->player->updateTeleport(false);
                }

                if ($this->timer > 0) {
                    $this->player->sendTip(str_replace("{SECONDS}",$this->timer,$this->player->translate("TP_COOLDOWN")));
                    $this->timer--;

                    $sound = new Sound();
                    $sound->sendSound($this->player,"note.harp");
                } else {
                    $this->player->sendTip($this->player->translate("TP_SUCCESS"));
                    $this->player->teleport($this->position);

                    $sound = new Sound();
                    $sound->sendSound($this->player,"note.harp");

                    Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                    $this->player->updateTeleport(false);
                }
            } else {
                $this->player->sendTip($this->player->translate("TP_FAIL"));

                $sound = new Sound();
                $sound->sendSound($this->player,"note.harp");

                Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                $this->player->updateTeleport(false);
                $this->player->removeEffect(Effect::BLINDNESS);
            }
        } else {
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}