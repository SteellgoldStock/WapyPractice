<?php

namespace UnknowG\WapyPractice\form\forms\box;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\modules\Reward;

class BoxForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                Reward::getReward($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle("Coffre de récompenses");
            $form->setContentAnArray($p->translate("BOX_REWARD"). "\n",[
                "§9- §f".$p->translate("RANK"). " §9VIP §r§f" . str_replace(array("{TIME}","{FORMAT}"),array(24,$p->translate("HOURS")),$p->translate("DURING_TEXT")) . " §f(§90.01%%§f)",
                "§9- §f".$p->translate("RANK"). " §9VIP+ §r§f" . str_replace(array("{TIME}","{FORMAT}"),array(24,$p->translate("HOURS")),$p->translate("DURING_TEXT")) . " §f(§90.01%%§f)",
                "§9- §f".$p->translate("RANK"). " §9Premium §r§f" . str_replace(array("{TIME}","{FORMAT}"),array(24,$p->translate("HOURS")),$p->translate("DURING_TEXT")) . " §f(§90.01%%§f)",
                "§9- §f".$p->translate("TAG"). " §9Chance §r§f" . $p->translate("TAG_TEXT") . " §f(§92%%§f)",
                "§9- §f".$p->translate("TAG"). " §9". $p->translate("OBSIDIAN")." §r§f" . $p->translate("TAG_TEXT") . " §f(§99%%§f)",
                "§9- §f".$p->translate("PET"). " §9". $p->translate("PARROT")."§r §f(§92%%§f)",
                "§9- §f".$p->translate("BOOSTER_XP")." §r§f(§930%%§f)",
                "§9- §f".$p->translate("CAPE")." Chance §r§f(§930%%§f)",
                "§9- §f".$p->translate("PERM_FLY_LOBBY") . " " . str_replace(array("{TIME}","{FORMAT}"),array(48,$p->translate("HOURS")),$p->translate("DURING_TEXT")) . " §f(§92.2%%%%§f)",
                "§9- §f"."500 ".$p->translate("COINS")." §r§f(§945%%§f)",
                "§9- §f"."1.000 ".$p->translate("COINS")." §r§f(§915%%§f)",
                "§9- §f"."5.000 ".$p->translate("COINS")." §r§f(§90.05%%§f)",
            ]);
            $form->addButton("Ouvrir",0,"textures/item/apple");
            $p->sendForm($form);
        }
    }
}