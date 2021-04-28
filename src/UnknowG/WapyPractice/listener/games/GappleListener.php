<?php

namespace UnknowG\WapyPractice\listener\games;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\games\GappleManager;
use UnknowG\WapyPractice\task\InstantTeleportTask;
use UnknowG\WapyPractice\utils\Positions;
use UnknowG\WapyPractice\Wapy;

class GappleListener implements Listener{
    public function __construct(){
        Wapy::getInstance()->getServer()->getPluginManager()->registerEvents($this, Wapy::getInstance());
    }
    
    public function onDeath(PlayerDeathEvent $event){
        if(!$event->getPlayer()->getLevel()->getName() == "gapple" OR !$event->getPlayer()->getLevel()->getName() == "gapple_ranked"){
            return;
        }else {
            $cause = $event->getEntity()->getLastDamageCause();
            if ($cause instanceof EntityDamageByEntityEvent) {
                $killer = $cause->getDamager();
                $victim = $event->getPlayer();

                if ($killer instanceof WAPlayer and $victim instanceof WAPlayer) {
                    $killer->gameStats["kills"]++;
                    $victim->gameStats["deaths"]++;
                    $killer->giveInventory("gapple");
                    $victim->respawn = $killer->getLevel()->getName();

                    if ($killer->ingame === "GAPPLE_RANKED" and $victim->ingame === "GAPPLE_RANKED") {
                        GappleManager::addPoint($killer);
                        GappleManager::delPoint($victim);
                    }
                }
            }
        }
    }

    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if($player instanceof WAPlayer){
            if($player->respawn == "gapple" OR $player->respawn == "gapple_ranked"){
                $r = mt_rand(1,4);
                Wapy::getInstance()->getScheduler()->scheduleDelayedTask(new InstantTeleportTask($player->getName(),Positions::GAPPLE_SPAWNPOINT[$r]["x"],Positions::GAPPLE_SPAWNPOINT[$r]["y"],Positions::GAPPLE_SPAWNPOINT[$r]["z"],$player->respawn),1);
                $player->giveInventory("gapple");
                $player->sendMessage($player->translate("GAPPLE_DEATH"));
            }
        }
    }
}