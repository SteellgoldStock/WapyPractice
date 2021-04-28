<?php

namespace UnknowG\WapyPractice\base;

use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\MovePlayerPacket;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\resources\LoadResources;
use UnknowG\WapyPractice\Wapy;

abstract class NPC extends Human
{
    /**
     * @var int
     */
    public $nameUpdate = 0;

    /**
     * @var int
     */
    public $moveUpdate = 0;

    /**
     * @var Vector3
     */
    public $pos;

    public function __construct(Level $level, CompoundTag $nbt){
        parent::__construct($level, $nbt);
        if (!is_null($this->getCustomSkin())) {
            $this->setSkin($this->getCustomSkin());
        }

        $this->setNameTagVisible(true);
        $this->spawnToAll();
    }

    public function getCustomSkin() : ?Skin{
        return null;
    }

    abstract public function onClick(WAPlayer $player) : void;

    public function getNameTagUpdate() : string{
        return "";
    }

    public static function createNBT(Vector3 $pos) : CompoundTag
    {
        $nbt = self::createBaseNBT($pos->floor()->add(0.5,0,0.5), null, 0,0);
        $nbt->setTag(clone LoadResources::getSkinTag());
        return $nbt;
    }


    /**
     * To remove the NPC
     * @param EntityDamageEvent $event
     */
    public function attack(EntityDamageEvent $event) : void{
        $event->setCancelled();
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getDamager();
            if ($player instanceof WAPlayer) {
                if ($player->getInventory()->getItemInHand()->getId() === Item::BONE) {
                    $this->close();
                } else {
                    $this->onClick($player);
                }
            }
        }
    }

    public function getPos() : Vector3{
        if (is_null($this->pos)) {
            $this->pos = new Vector3($this->getX(), $this->getY(), $this->getZ());
        }
        return $this->pos;
    }

    /**
     * @param int $currentTick
     * @return bool
     */
    public function onUpdate(int $currentTick) : bool{
        parent::onUpdate($currentTick);
        if (!$this->isClosed()) {
            if (time() >= $this->nameUpdate) {
                if ($this->getNameTag() !== $this->getNameTagUpdate()) {
                    $this->setNameTag($this->getNameTagUpdate());
                    $this->nameUpdate = (int) time() + (int) 20;
                }
            }

            if (Time::getMicroTime() >= $this->moveUpdate) {
                $this->moveUpdate = Time::getMicroTime() + 400;
                foreach (Wapy::getInstance()->getServer()->getOnlinePlayers() as $player) {
                    $distance = $player->distance($this);
                    if ($distance <= 10) {
                        $pk = new MovePlayerPacket();
                        $pk->entityRuntimeId = $this->id;
                        $pk->position = $this->add(0,$this->height ,0);
                        $xdiff = $player->x - $this->x;
                        $zdiff = $player->z - $this->z;
                        $angle = atan2($zdiff, $xdiff);
                        $pk->yaw = (($angle * 180) / M_PI) - 90;
                        $pk->pitch = 5;
                        $pk->headYaw = $pk->yaw;
                        $player->sendDataPacket($pk);
                    }
                }
            }
            $this->setPosition($this->getPos());
        }
        return !$this->isClosed();
    }
}
