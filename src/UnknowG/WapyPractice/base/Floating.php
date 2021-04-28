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

abstract class Floating extends Human
{
    /**
     * @var int
     */
    public $yawMove = 0;

    /**
     * @var int
     */
    public $yMove = 0;

    /**
     * @var int
     */
    public $less = false;

    /**
     * @var int
     */
    public $moveUpdate = 0;

    /**
     * @var Vector3
     */
    public $pos;

    public function __construct(Level $level, CompoundTag $nbt)
    {
        parent::__construct($level, $nbt);

        if (!is_null($this->getCustomSkin())) {

            $this->setSkin($this->getCustomSkin());

        }

        $this->setNameTag($this->getCustomNameTag());
        $this->setNameTagVisible(true);
        $this->spawnToAll();
    }

    public function getCustomSkin() : ?Skin
    {
        return null;
    }

    abstract public function onClick(WAPlayer $player) : void;

    public function getCustomNameTag() : string
    {
        return "";
    }

    public static function createNBT(Vector3 $pos) : CompoundTag
    {
        $nbt = self::createBaseNBT($pos->floor()->add(0.5,0,0.5), null, 0,0);
        $nbt->setTag(clone LoadResources::getSkinTag());
        return $nbt;
    }

    public function getPos() : Vector3
    {
        if (is_null($this->pos)) {

            $this->pos = new Vector3($this->getX(), $this->getY(), $this->getZ());

        }

        return $this->pos;
    }

    /**
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

    /**
     * @param int $currentTick
     * @return bool
     */
    public function onUpdate(int $currentTick) : bool{
        parent::onUpdate($currentTick);
        if (!$this->isClosed()) {
            if (Time::getMicroTime() >= $this->moveUpdate) {
                $this->moveUpdate = Time::getMicroTime() + 100;
                $this->yawMove += 5;
                if ($this->yawMove > 360) {
                    $this->yawMove = 0;
                }

                if ($this->less) {
                    $this->yMove -= 0.02;
                } else {
                    $this->yMove += 0.02;
                }

                if ($this->yMove <= - 0.3) {
                    $this->less = false;
                }

                if ($this->yMove >= 0.3) {
                    $this->less = true;
                }

                $pk = new MovePlayerPacket();
                $pk->entityRuntimeId = $this->id;
                $pk->position = $this->add(0, 2 + $this->yMove ,0);
                $pk->yaw = $this->yawMove;
                $pk->pitch = $this->pitch;
                $pk->headYaw = $pk->yaw;
                Wapy::getInstance()->getServer()->broadcastPacket($this->getViewers(), $pk);

                $this->setPosition($this->getPos());
            }
        }

        return !$this->isClosed();
    }

}