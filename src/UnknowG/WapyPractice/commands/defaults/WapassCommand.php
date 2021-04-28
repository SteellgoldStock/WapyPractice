<?php

namespace UnknowG\WapyPractice\commands\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use UnknowG\WapyPractice\api\Time;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\forms\wapass\WapassHome;

class WapassCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if($player instanceof WAPlayer){
            WapassHome::open($player);
        }
    }
}