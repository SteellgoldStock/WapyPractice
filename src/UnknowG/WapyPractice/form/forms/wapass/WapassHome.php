<?php

namespace UnknowG\WapyPractice\form\forms\wapass;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;

class WapassHome extends SimpleForm{
    public static function open(WAPlayer $p)
    {
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                BoostersForm::open($p);
                                break;
                            case 1:
                                self::rewards($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("WAPASS_TITLE"));
            $form->setContent(str_replace(
                array("{EXP}","{LEVEL}","{NEXT_REWARD}"),
                array($p->wpxp,$p->wplevel,"Aucune"),
                $p->translate("WAPASS_HOME")
            ));
            $form->addButton($p->translate("BOOSTERS"), 0, "textures/items/totem");
            $form->addButton($p->translate("WAPASS_REWARD_LIST"), 0, "textures/items/book_normal");
            $p->sendForm($form);
        }
    }

    public static function rewards(WAPlayer $p)
    {
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data){
                            case 0:
                                self::ri($p,"NUTELLA");
                                break;
                            case 1:
                                self::ri($p,"FOX");
                                break;
                            case 2:
                                self::ri($p,"TNT_LAUNCHER");
                                break;
                            case 3:
                                self::ri($p,"SNOWBALL");
                                break;
                            case 4:
                                self::ri($p,"SLIMEBALL");
                                break;
                        }
                    }
                }
            );

            // TEMPORARY FOR TEST
            $status = $p->translate("LOCKED");
            $status1 = $p->translate("UNLOCKED");

            // TODO: AUTOMAT THE LANG
            $form->setTitle($p->translate("WAPASS_TITLE"));
            $form->addButton($p->translate("RW_1")."\n§l".$p->translate("LEVEL")." - $status");
            $form->addButton($p->translate("RW_2")."\n§l".$p->translate("LEVEL")."10 - $status");
            $form->addButton($p->translate("RW_3")."\n§l".$p->translate("LEVEL")."11 - $status");
            $form->addButton($p->translate("RW_4")."\n§l".$p->translate("LEVEL")."12 - $status");
            $form->addButton($p->translate("RW_5")."\n§l".$p->translate("LEVEL")."13 - $status");
            $p->sendForm($form);
        }
    }

    public static function ri(WAPlayer $p, String $item)
    {{
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) use ($item) {
                    if ($data === null) {
                        self::rewards($p);
                    } else {
                    }
                }
            );

            $form->setTitle($p->translate("WAPASS_TITLE"));
            $form->setContent($p->translate($item));
            $form->addButton($p->translate("BACK"));
            $p->sendForm($form);
    }}
}