<?php

namespace UnknowG\WapyPractice\listener\games;

use pocketmine\block\BlockIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\EnderPearl;
use pocketmine\Server;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\games\FILManager;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\Wapy;

class FILListener implements Listener{
    public function __construct(){
        Wapy::getInstance()->getServer()->getPluginManager()->registerEvents($this, Wapy::getInstance());
    }

    public function onMove(PlayerMoveEvent $event){
        $p = $event->getPlayer();
        if(!$p instanceof WAPlayer){ return; }
        if(!$p->ingame == "FIL"){ return; }

        $b = $p->getLevel()->getBlock($p->floor()->subtract(0, 1));
        if($b->getId() == BlockIds::STAINED_GLASS){
            if(Time::$cooldown[$p->getName()] < time()) {
                Time::$cooldown[$p->getName()] = time() + 1;
                FILManager::addPlayer($p);
                Server::getInstance()->getLevelByName($p->getLevel()->getName())->setTime(13000);
                $p->sendTip($p->translate("GAPPLE_DEATH").Text::PREFIX_REVERSED);

                if($p->lastTouch !== null){
                    $to = Server::getInstance()->getPlayer($p->lastTouch);
                    if($to instanceof WAPlayer){
                        $to->addWPXP();
                        $to->combo = 0;
                        $p->combo = 0;
                        $p->lastTouch = null;
                    }
                }
            }
        }
    }

    /**
    public function onInteract(PlayerInteractEvent $event){
        $item = $event->getItem();
        $player = $event->getPlayer();
        if (!$player instanceof WAPlayer) return;
        if (!$player->ingame == "FIL") return;

        if ($item instanceof EnderPearl) {
            if (Time::$enderpearl[$player->getName()] <= time()) {
                Time::$enderpearl[$player->getName()] = time() + 10;
                $player->giveInventory("fil");
            } else {
                $event->setCancelled();
                $player->sendTip(str_replace("{TIME}", Time::$enderpearl[$player->getName()] - time(), $player->translate("ENDER_PEARL")));
            }
        }
    }
     **/

    public function cancelDamages(EntityDamageEvent $ev){
        $entity = $ev->getEntity();
        if ($entity instanceof WAPlayer) {
            if ($ev->getCause() == EntityDamageEvent::CAUSE_FALL) {
                if ($entity->ingame == "FIL" or $entity->ingame == null) {
                    $ev->setCancelled();
                }
            }
        }
    }

    public function saveKill(EntityDamageByEntityEvent $ev){
        $player = $ev->getEntity();
        $damager = $ev->getDamager();

        if($player instanceof WAPlayer && $damager instanceof WAPlayer){
            if($player->ingame == "FIL"){
                $player->setHealth(20);
                $damager->setHealth(20);
            }
        }
    }
}