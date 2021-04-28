<?php

namespace UnknowG\WapyPractice\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\forms\cosmetics\CosmeticForm;
use UnknowG\WapyPractice\form\forms\player\SettingsForm;
use UnknowG\WapyPractice\form\forms\friends\FriendsForm;
use UnknowG\WapyPractice\form\forms\games\GamesForm;
use UnknowG\WapyPractice\form\forms\wapass\WapassHome;
use UnknowG\WapyPractice\Wapy;

class ItemsListener implements Listener{
    public function __construct(){
        Wapy::getInstance()->getServer()->getPluginManager()->registerEvents($this, Wapy::getInstance());
    }

    public function onInteract(PlayerInteractEvent $event){
        $item = $event->getItem()->getId();
        $player = $event->getPlayer();
        if(!$player->getLevel()->getName() == "lobby"){ return; }

        if($player instanceof WAPlayer){
            if(in_array($item,[ItemIds::ANVIL,ItemIds::TOTEM,ItemIds::COMPASS,ItemIds::MINECART_WITH_COMMAND_BLOCK,ItemIds::DIAMOND_HORSE_ARMOR])){
                $event->setCancelled();
                if(Time::$cooldown[$player->getName()] < time()){
                    Time::$cooldown[$player->getName()] = time() + 1;

                    switch ($item){
                        case ItemIds::ANVIL:
                            SettingsForm::open($player);
                            break;
                        case ItemIds::COMPASS:
                            GamesForm::open($player);
                            break;
                        case ItemIds::TOTEM:
                            FriendsForm::open($player);
                            break;
                        case ItemIds::MINECART_WITH_COMMAND_BLOCK:
                            WapassHome::open($player);
                            break;
                        case ItemIds::DIAMOND_HORSE_ARMOR:
                            CosmeticForm::open($player);
                            break;
                    }
                }else{
                    $player->sendTip(str_replace("{SECONDS}",Time::$cooldown[$player->getName()] - time(),$player->translate("PATIENT_ITEM_CLICK")));
                }
            }
        }
    }
}
