<?php

namespace UnknowG\WapyPractice\commands\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use UnknowG\WapyPractice\base\NPC;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\entity\npc\BoxNPC;
use UnknowG\WapyPractice\form\forms\player\ManagerForm;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\Wapy;

class ManageCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if ($player instanceof WAPlayer) {
            if (Ranks::hasPermission($player->getRank(), "manage",$player->getSubRank())) {
                ManagerForm::open($player);
            }else{
                $player->sendMessage(str_replace("{ACTION}","Manage Command",$player->translate("PERMISSION_ERROR")));
            }
        }
    }
}