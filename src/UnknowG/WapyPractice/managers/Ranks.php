<?php

namespace UnknowG\WapyPractice\managers;

use UnknowG\WapyPractice\utils\Colors as C;
use UnknowG\WapyPractice\utils\Permissions;

class Ranks {
    public static $ranks = [];

    public function register(string $id, Array $displays, Array $commands, String $primaryColor, String $secondaryColor, Int $isSub, String $isOp){
        self::$ranks[$id] = [
            "name"=>$displays,
            "commands"=>$commands,
            "colors"=>[
                "secondary"=>$primaryColor,
                "primary"=>$secondaryColor
            ],
            "isSub"=>$isSub,
            "isOp"=>$isOp
        ];
    }

    public static function hasPermission(String $rank, String $permission, String $subRank = "PLAYER"): bool{
        if(in_array($permission,Ranks::$ranks[$rank]["commands"]) OR in_array($permission,Ranks::$ranks[$subRank]["commands"]) OR Ranks::$ranks[$rank]["isOp"] == true){
            return true;
        }else{
            return false;
        }
    }

    public function init(){
        $this->register("PLAYER",["fr"=>"Joueur","en"=>"Player"],Permissions::PLAYER,C::GRAY, C::GRAY,false,false);
        $this->register("VIP",["fr"=>"VIP","en"=>"VIP"],Permissions::VIP,C::GREEN, C::GRAY,true,false);
        $this->register("VIP_PLUS",["fr"=>"VIP+","en"=>"VIP+"],Permissions::VIP_PLUS,C::DARK_GREEN, C::GRAY,true,false);
        $this->register("PREMIUM",["fr"=>"Premium","en"=>"Premium"],Permissions::PREMIUM,C::GOLD, C::WHITE,true,false);
        $this->register("BOOSTER",["fr"=>"Boosteur","en"=>"Booster"],Permissions::BOOSTER,C::LIGHT_PURPLE, C::GRAY,true,false);
        $this->register("YOUTUBER",["fr"=>"Vidéaste","en"=>"YouTuber"],Permissions::YOUTUBER,C::RED, C::GRAY,true,false);
        $this->register("HELPER",["fr"=>"Guide","en"=>"Helper"],Permissions::HELPER,C::AQUA, C::GRAY,false,false);
        $this->register("MODERATOR",["fr"=>"Modo","en"=>"Mod"],Permissions::MODERATOR,C::ORANGE, C::GRAY,false,false);
        $this->register("ADMINISTRATOR",["fr"=>"Admin","en"=>"Admin"],Permissions::ADMINISTRATOR,C::YELLOW, C::GRAY,false,false);
        $this->register("OWNER",["fr"=>"Fonda","en"=>"Owner"],Permissions::OWNER,C::BLUE, C::GRAY,false,true);
    }
}