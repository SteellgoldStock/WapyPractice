<?php

namespace UnknowG\WapyPractice\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\Gambler;
use UnknowG\WapyPractice\form\forms\player\LobbyForm;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\modules\CombatLogger;
use UnknowG\WapyPractice\task\CombatLoggerTask;
use UnknowG\WapyPractice\task\player\PlayerRegistering;
use UnknowG\WapyPractice\task\TchatAsync;
use UnknowG\WapyPractice\utils\Positions;
use UnknowG\WapyPractice\Wapy;

class PlayerListener implements Listener{
    public const PROTECTEDS = ["lobby","FIL_1","FIL_2"];

    public function __construct(){
        Wapy::getInstance()->getServer()->getPluginManager()->registerEvents($this, Wapy::getInstance());
    }

    public function onPlayerCreation(PlayerCreationEvent $event){
        $event->setPlayerClass(WAPlayer::class);
    }

    public function onPlace(BlockPlaceEvent $event){
        $player = $event->getPlayer();
        if($player instanceof WAPlayer AND !Ranks::hasPermission($player->getRank(),"blockPlace")){
            $event->setCancelled();
            $player->sendTip(str_replace("{ACTION}","Protected World",$player->translate("ACTION_REFUSED")) . Text::PREFIX_REVERSED);
            return;
        }
    }

    public function onBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        if($player instanceof WAPlayer AND !Ranks::hasPermission($player->getRank(),"blockBreak")){
            $event->setCancelled();
            $player->sendTip(str_replace("{ACTION}","Protected World",$player->translate("ACTION_REFUSED")) . Text::PREFIX_REVERSED);
            return;
        }
    }

    public function onJoin(PlayerJoinEvent $event){
        $event->setJoinMessage(null);
        $player = $event->getPlayer();
        Time::$cooldown[$player->getName()] = time();
        Time::$enderpearl[$player->getName()] = time();

        $player->teleport(new Position(-3,67,10,Server::getInstance()->getLevelByName("lobby")));

        if($player instanceof WAPlayer){
            $player->wpxp = $player->getWPXP();
            $player->wplevel = $player->getWPLevel();
            $player->gameStats = [
                "kills"=>0,
                "deaths"=>0,
                "lpoints"=>0,
            ];

            $player->ingame = null;
            $player->scorebard = true;
            $player->respawn = null;
            $player->asBoost = false;
            $player->xpWithBoost = 0;

            $player->giveInventory("lobby");

            Wapy::getInstance()->getServer()->getAsyncPool()->submitTask(new PlayerRegistering($event->getPlayer()->getName()));
        }
    }

    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();
        if($player instanceof WAPlayer){
            if(!$player->respawn == null){
                return;
            }

            $player->teleport(new Position(Positions::SPAWN["x"],Positions::SPAWN["y"],Positions::SPAWN["z"],Server::getInstance()->getLevelByName("lobby")));
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $event->setQuitMessage(null);
    }

    public function onMove(PlayerMoveEvent $event){
        $p = $event->getPlayer();
        if(!$p instanceof WAPlayer){ return; }
        if(!$p->getLevel()->getName() == "lobby"){ return; }

        $b = $p->getLevel()->getBlock($p->floor()->subtract(0, 1));
        if($b->getId() == 49){
            if(Time::$cooldown[$p->getName()] < time()) {
                Time::$cooldown[$p->getName()] = time() + 3;
                LobbyForm::open($p);
            }
        }
    }

    public function onDamage(EntityDamageByEntityEvent $ev){
        $player = $ev->getEntity();
        $damager = $ev->getDamager();

        if ($player instanceof WAPlayer && $damager instanceof WAPlayer) {
            if($damager->getLevel()->getName() == "lobby"){
                $ev->setCancelled();
                return;
            }

            if($player->combo >= 0){
                $damager->combo++;
                $player->combo = 0;
            }

            $damager->sendTip(Text::PREFIX . "§fCOMBO: " . $damager->combo . Text::PREFIX_REVERSED);

            if(!CombatLogger::isInCombat($player)){
                CombatLogger::setCombat($player);
                Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new CombatLoggerTask($player),20);
            }

            if(!CombatLogger::isInCombat($damager)){
                CombatLogger::setCombat($damager);
                Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new CombatLoggerTask($damager),20);
            }
        }
    }

    public function onChat(PlayerChatEvent $event){
        $event->setCancelled();
        $p = $event->getPlayer();
        Wapy::getInstance()->getServer()->getAsyncPool()->submitTask(new TchatAsync($p->getName(),$event->getMessage()));
    }

    public function onExhaust(PlayerExhaustEvent $event){
        $event->setCancelled();
    }

    public function onDeath(PlayerDeathEvent $event){
        $cause = $event->getEntity()->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();
            $victim = $event->getPlayer();
            if($killer instanceof WAPlayer AND $victim instanceof WAPlayer){
                $killer->addWPXP();
                $killer->combo = 0;
                $victim->combo = 0;
            }
        }
    }
}
