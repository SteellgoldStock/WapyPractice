<?php

namespace UnknowG\WapyPractice\entity\npc;

use pocketmine\entity\Skin;
use UnknowG\WapyPractice\base\Floating;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\forms\box\BoxForm;
use UnknowG\WapyPractice\modules\Reward;
use UnknowG\WapyPractice\resources\LoadResources;

class BoxNPC extends Floating {

    public $width = 1;
    public $height = 1.3;

    public function getName(): string{
        return "BoxNPC";
    }

    public function onClick(WAPlayer $player): void{
        if($player->hasKey()){
            if($player->isSneaking()){
                Reward::getReward($player);
            }else{
                BoxForm::open($player);
            }
        }else{
            $player->translate("NO_KEYS");
        }
    }

    public function getCustomSkin() : ?Skin{
        return new Skin("Box",LoadResources::PNGtoBYTES("box"),"","geometry.box",LoadResources::getGeometry("box"));
    }
}