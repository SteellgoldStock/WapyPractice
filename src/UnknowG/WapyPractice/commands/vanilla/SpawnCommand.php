<?php

namespace UnknowG\WapyPractice\commands\vanilla;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\modules\CombatLogger;
use UnknowG\WapyPractice\task\TeleportTask;
use UnknowG\WapyPractice\utils\Positions;
use UnknowG\WapyPractice\Wapy;

class SpawnCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if ($player instanceof WAPlayer) {
            if ($player->getLevel()->getName() == "lobby") {
                if (!$player->ingame == null) {
                    $player->ingame = null;
                }

                $player->giveInventory("lobby");
                $player->teleport(new Position(Positions::SPAWN["x"], Positions::SPAWN["y"], Positions::SPAWN["z"], Server::getInstance()->getLevelByName("lobby")));
            } else {
                // rr
            }
        }
    }
}