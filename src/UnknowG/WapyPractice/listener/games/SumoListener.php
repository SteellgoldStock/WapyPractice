<?php

namespace UnknowG\WapyPractice\listener\games;

use pocketmine\block\BlockIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\games\FILManager;
use UnknowG\WapyPractice\managers\games\SumoManager;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\utils\Positions;
use UnknowG\WapyPractice\Wapy;

class SumoListener implements Listener{
    public function __construct(){
        Wapy::getInstance()->getServer()->getPluginManager()->registerEvents($this, Wapy::getInstance());
    }

    public function onMove(PlayerMoveEvent $event){
        $p = $event->getPlayer();
        if(!$p instanceof WAPlayer){ return; }
        if(!$p->ingame == "SUMO"){ return; }

        $b = $p->getLevel()->getBlock($p->floor()->subtract(0, 1));
        $l = $p->getLevel();
        if($b->getId() == 159 AND $b->getDamage() == 0){
            if(Time::$cooldown[$p->getName()] < time()) {
                Time::$cooldown[$p->getName()] = time() + 1;
                Server::getInstance()->getLevelByName($p->getLevel()->getName())->setTime(1000);

                $red = Server::getInstance()->getPlayer(SumoManager::$waitingList[$l->getName()]["red"]["player"]);
                $blue = Server::getInstance()->getPlayer(SumoManager::$waitingList[$l->getName()]["blue"]["player"]);

                $red->teleport(new Position(Positions::SUMO_SPAWNPOINT[$l->getName()]["rX"],Positions::SUMO_SPAWNPOINT[$l->getName()]["rY"],Positions::SUMO_SPAWNPOINT[$l->getName()]["rZ"],$l));
                $blue->teleport(new Position(Positions::SUMO_SPAWNPOINT[$l->getName()]["bX"],Positions::SUMO_SPAWNPOINT[$l->getName()]["bY"],Positions::SUMO_SPAWNPOINT[$l->getName()]["bZ"],$l));

                if($red instanceof WAPlayer AND $blue instanceof WAPlayer) {
                    $red->combo = 0;
                    $blue->combo = 0;

                    if ($red->getName() == $p->getName()) {
                        $blue->gameStats["kills"]++;
                        $red->gameStats["deaths"]++;
                    }elseif($blue->getName() == $p->getName()) {
                        $red->gameStats["kills"]++;
                        $blue->gameStats["deaths"]++;
                    }

                    SumoManager::checkWinner($red,$blue,$l);
                }
            }
        }
    }

    public function cancelDamages(EntityDamageEvent $ev){
        $entity = $ev->getEntity();
        if ($entity instanceof WAPlayer) {
            if ($ev->getCause() == EntityDamageEvent::CAUSE_FALL) {
                if ($entity->ingame == "SUMO" or $entity->ingame == null) {
                    $ev->setCancelled();
                }
            }
        }
    }

    public function saveKill(EntityDamageByEntityEvent $ev){
        $player = $ev->getEntity();
        $damager = $ev->getDamager();

        if($player instanceof WAPlayer && $damager instanceof WAPlayer){
            if($player->ingame == "SUMO"){
                $player->setHealth(20);
                $damager->setHealth(20);
            }
        }
    }
}