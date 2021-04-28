<?php

namespace UnknowG\WapyPractice\commands\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use UnknowG\WapyPractice\base\NPC;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\entity\npc\BoxNPC;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\Wapy;

class NPCCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if ($player instanceof WAPlayer) {
            if (Ranks::hasPermission($player->getRank(), "npc",$player->getSubRank())) {
                switch ($args[0]) {
                    case "lobby":
                        $nbt = NPC::createNBT($player);
                        Entity::createEntity("LobbyNPC", $player->getLevel(), $nbt);
                        break;
                    case "box":
                        $nbt = BoxNPC::createNBT($player);
                        Entity::createEntity("BoxNPC",$player->getLevel(),$nbt);
                        break;
                }

                $player->sendMessage(str_replace("{NAME}", $args[0], $player->translate("NPC_SPAWN")));
            }else{
                $player->sendMessage(str_replace("{ACTION}","Spawn NPC",$player->translate("PERMISSION_ERROR")));
            }
        }
    }
}