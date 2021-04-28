<?php

namespace UnknowG\WapyPractice\entity\npc;

use UnknowG\WapyPractice\base\NPC;
use UnknowG\WapyPractice\base\WAPlayer;

class LobbyNPC extends NPC{
    public function getName(): string{
        return "LobbyNPC";
    }

    public function getNameTagUpdate(): string{
        return "§9- §fRetourner au Lobby §9-";
    }

    public function onClick(WAPlayer $player): void{
        $player->sendMessage($player->translate("LOBBY_TELEPORT_WAIT"));
    }
}