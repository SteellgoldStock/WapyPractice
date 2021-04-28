<?php

namespace UnknowG\WapyPractice\api;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use UnknowG\WapyPractice\base\WAPlayer;

class Sound{
    public function sendSound(WAPlayer $player, String $soundName){
        $pk = new PlaySoundPacket();
        $pk->soundName = $soundName;
        $pk->pitch = 1;
        $pk->volume = 100;
        $pk->x = $player->x;
        $pk->y = $player->y;
        $pk->z = $player->z;
        $player->sendDataPacket($pk);
    }
}