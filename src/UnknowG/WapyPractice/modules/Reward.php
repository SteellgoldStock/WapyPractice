<?php

namespace UnknowG\WapyPractice\modules;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Text;

class Reward{
    public static function getReward(WAPlayer $player){
        $num = mt_rand(0,100);
        if($num >= 10 && $num <= 10) {
            $r = mt_rand(1, 3);
            if ($r == 1) {
                // TAG CHANCE
                $player->sendMessage(str_replace(""));
            } elseif ($r == 2) {
                // TAG OBSI
                $player->sendMessage(str_replace(""));
            } elseif ($r == 3) {
                $player->addMoney(5000);
            }
        }elseif($num >= 20 && $num <= 20){
            $r = mt_rand(1,3);
            if($r == 1){
                // PET PARROT
                $player->sendMessage(str_replace(""));
            }elseif($r == 2){
                // CAPE CHANCE
                $player->sendMessage(str_replace(""));
            }elseif($r == 3){
                $player->addMoney(1000);
            }
        }elseif($num >= 1 && $num <= 1){
            $r = mt_rand(1,3);
            if($r == 1){
                if($player->getRank() == "VIP" OR $player->getRank() == "VIP_PLUS" OR $player->getRank() == "PREMIUM"){

                }else{
                    $player->setRankReward("VIP",time() + 60 * 60 * 24,$player->getRank());
                    $player->sendMessage(str_replace(""));
                }
            }elseif($r == 2){
                if($player->getRank() == "VIP_PLUS" OR $player->getRank() == "PREMIUM"){

                }else{
                    $player->setRankReward("VIP_PLUS",time() + 60 * 60 * 24,$player->getRank());
                    $player->sendMessage(str_replace(""));
                }
            }elseif($r == 3){
                if($player->getRank() == "PREMIUM"){

                }else{
                    $player->setRankReward("PREMIUM",time() + 60 * 60 * 24,$player->getRank());
                    $player->sendMessage(str_replace(""));
                }
            }
        }elseif($num >= 60 && $num <= 60){
            $player->addBoosters();
            $player->sendMessage(str_replace(""));
        }elseif($num >= 30 && $num <= 30){
            $player->addMoney(500);
            $player->sendMessage(str_replace(""));
        }elseif($num >= 70 && $num <= 70){
            // PERM
            $player->sendMessage(str_replace(""));
        }else{
            $player->sendTip(Text::PREFIX . " + §9500@ §f+ " . Text::PREFIX_REVERSED);
        }
    }
}