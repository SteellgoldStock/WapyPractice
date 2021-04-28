<?php

namespace UnknowG\WapyPractice\commands\vanilla;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Text;

class ListCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        $playerNames = array_map(function(WAPlayer $p) : string{
            return $p->getName();
        }, array_filter($player->getServer()->getOnlinePlayers(), function(WAPlayer $p) use ($player) : bool{
            return !($player instanceof WAPlayer) or $player->canSee($p);
        }));
        sort($playerNames, SORT_STRING);

        $player->sendMessage(Text::PRIMARY_COLOR . "- §fListe des joueurs connectés sur Wapy ".Text::PRIMARY_COLOR."(".count($playerNames)."/".$player->getServer()->getMaxPlayers().")".Text::PRIMARY_COLOR." -");
        $player->sendMessage(Text::PRIMARY_COLOR .implode("§f,§9 ", $playerNames));
    }
}
