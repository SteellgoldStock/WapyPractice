<?php

namespace UnknowG\WapyPractice\form\forms\player;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\Gambler;
use UnknowG\WapyPractice\form\api\CustomForm;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\BasicForm;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\utils\User;
use UnknowG\WapyPractice\Wapy;

class SettingsForm extends CustomForm{
    public static function open(WAPlayer $p){
        {
            $form = new CustomForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) return;

                    Gambler::edit("setting_showOS", User::returnInt($data[0]), $p->getName());
                    Gambler::edit("setting_receiveMP", User::returnInt($data[1]), $p->getName());
                    Gambler::edit("setting_receiveFR", User::returnInt($data[2]), $p->getName());
                    Gambler::edit("setting_animation_lp", User::returnInt($data[3]), $p->getName());
                    Gambler::edit("setting_timerBoost", User::returnInt($data[4]), $p->getName());
                    Gambler::edit("setting_combatTip", User::returnInt($data[5]), $p->getName());

                    if (Ranks::hasPermission($p->getRank(), "vip_plus",$p->getSubRank())) {
                        Gambler::edit("setting_fly", User::returnInt($data[6]), $p->getName());
                    }

                    if (Ranks::hasPermission($p->getRank(), "premium",$p->getSubRank())) {
                        Wapy::$deviceOS[$p->getName()] = $data[7];
                    }

                    $p->sendMessage($p->translate("SETTINGS_SAVED"));
                }
            );

            $form->setTitle($p->translate("SETTINGS_TITLE"));
            $form->addToggle($p->translate("SETTINGS_SHOW_OS") . $p->getSettingsStatus("SHOW_OS"), $p->getSettings("SHOW_OS"));
            $form->addToggle($p->translate("SETTINGS_PRIVATE_MESSAGES") . $p->getSettingsStatus("PRIVATE_MESSAGE"), $p->getSettings("PRIVATE_MESSAGE"));
            $form->addToggle($p->translate("SETTINGS_FRIEND_REQUEST") . $p->getSettingsStatus("FRIEND_REQUEST"), $p->getSettings("FRIEND_REQUEST"));
            $form->addToggle($p->translate("SETTINGS_ANIMATION_LEVEL_UP") . $p->getSettingsStatus("LEVEL_UP_ANIMATION"), $p->getSettings("LEVEL_UP_ANIMATION"));
            $form->addToggle($p->translate("SETTINGS_TIMER_BOOST") . $p->getSettingsStatus("TIMER_BOOST"), $p->getSettings("TIMER_BOOST"),"d");
            $form->addToggle($p->translate("SETTINGS_COMBAT_TIP") . $p->getSettingsStatus("COMBAT_TIP"), $p->getSettings("COMBAT_TIP"));
            // $form->addDropdown("Grade en première place",[$p->getRank(),$p->getSubRank()]);
            $form->addToggle($p->translate("SETTINGS_FLY") . $p->getSettingsStatus("FLY"), $p->getSettings("FLY"), "g");
            $form->addDropdown($p->translate("SETTINGS_FAKE_OS"), User::OS_LIST, Wapy::$deviceOS[$p->getName()], "g");
            $p->sendForm($form);
        }
    }
}