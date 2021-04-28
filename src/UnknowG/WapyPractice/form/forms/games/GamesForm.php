<?php

namespace UnknowG\WapyPractice\form\forms\games;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\games\category\PvpGamesForm;
use UnknowG\WapyPractice\form\forms\games\category\RankedGamesForm;

class GamesForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                PvpGamesForm::open($p);
                                break;
                            case 1:
                                $p->sendMessage(str_replace("{CATEGORY}",$p->translate("FORMS_GAMES_HOME_BUTTONS_MINIGAMES"),$p->translate("NO_GAMES_FOUND")));
                                break;
                            case 2:
                                $p->sendMessage(str_replace("{CATEGORY}",$p->translate("FORMS_GAMES_HOME_BUTTONS_EVENTS"),$p->translate("NO_GAMES_FOUND")));
                                break;
                            case 3:
                                if($p->getRank() !== "OWNER") $p->sendMessage(str_replace("{ACTION}","Pre-Beta BYPASS",$p->translate("PERMISSIONS_ERROR"))); return;
                                // RankedGamesForm::open($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_GAMES_HOME_TITLE"));
            $form->setContent($p->translate("FORMS_GAMES_HOME_DESCRIPTION"));
            $form->addButton("PvP (3)",0,'textures/items/iron_sword');
            $form->addButton($p->translate("FORMS_GAMES_HOME_BUTTONS_MINIGAMES") . " (0)",0,'textures/items/bed_lime');
            $form->addButton($p->translate("FORMS_GAMES_HOME_BUTTONS_EVENTS")." (0)",0,'textures/items/totem');
            $form->addButton($p->translate("FORMS_GAMES_HOME_BUTTONS_RANKED")." (1)",0,'textures/items/diamond');
            $p->sendForm($form);
        }
    }
}