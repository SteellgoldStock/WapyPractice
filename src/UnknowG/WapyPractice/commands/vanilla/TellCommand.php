<?php

namespace UnknowG\WapyPractice\commands\vanilla;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use UnknowG\WapyPractice\base\WAPlayer;

class TellCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if ($player instanceof WAPlayer) {
            if (!isset($args[0])) {
                $player->sendMessage(str_replace(array("{ARG}", "{ARG_TYPE}"), array(0, $player->translate("PLAYER_NAME")), $player->translate("ARGUMENT_MISSING")));
                return;
            }

            if (!isset($args[1])) {
                $player->sendMessage(str_replace(array("{ARG}", "{ARG_TYPE}"), array(1, $player->translate("MESSAGE")), $player->translate("ARGUMENT_MISSING")));
                return;
            }

            $to = $player->getServer()->getPlayer(array_shift($args));

            if ($to instanceof WAPlayer) {
                if ($to->getSettings("PRIVATE_MESSAGE") == 1) {
                    $player->sendMessage(str_replace("{PLAYER}", $to->getName(), $to->translate("DISABLED_PRIVATES_MESSAGE")));
                    return;
                }
            }

            if ($player === $to) {
                $player->sendMessage($player->translate("SAME_PLAYER"));
                return;
            }

            $name = $player->getName();
            $message = implode(" ", $args);
            $pName = $to->getName();

            $format1 = "§9- Envoyé à " . $pName . " §l»§r§f " . $message;
            $format2 = "§9- Reçu de " . $name . " §l»§r§f " . $message;

            $player->sendMessage($format1);
            $to->sendMessage($format2);
        } else {
            $player->sendMessage(str_replace("{PLAYER}", $args[0], $player->translate("PLAYER_DISCONNECTED")));
        }
    }
}