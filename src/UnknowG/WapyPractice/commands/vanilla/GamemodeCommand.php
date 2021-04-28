<?php

namespace UnknowG\WapyPractice\commands\vanilla;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Ranks;

class GamemodeCommand extends Command{
    public const MODES = ["0","1","2","3"];
    public const MODES_NAME = [0=>"Survival",1=>"Creative",2=>"Adventure",3=>"Spectator"];

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args){
        if($player instanceof WAPlayer){
            if(Ranks::hasPermission($player->getRank(),"gamemode",$player->getSubRank())){
                if(isset($args[0])){
                    if(in_array($args[0],self::MODES)){
                        if($args[0] == 1 AND $player->getRank() == "MODERATOR"){
                            $player->sendMessage(str_replace("{ACTION}","Gamemode Creative",$player->translate("ACTION_REFUSED")));
                            return;
                        }

                        $player->setGamemode($args[0]);
                        $player->sendMessage(str_replace("{NEW}",self::MODES_NAME[$args[0]],$player->translate("GAMEMODE_CHANGE")));
                        return;
                    }else{
                        $player->sendMessage(str_replace("{LIST}","§90§f, §91§f, §92§f, §93",$player->translate("ARGUMENT_ERROR")));
                        return;
                    }
                }else{
                    $player->sendMessage(str_replace(array("{ARG}","{ARG_TYPE}"),array(0,"Gamemode Type"),$player->translate("ARGUMENT_MISSING")));
                    return;
                }
            }else{
                $player->sendMessage(str_replace("{ACTION}","Gamemode Command",$player->translate("PERMISSION_ERROR")));
                return;
            }
        }
    }
}