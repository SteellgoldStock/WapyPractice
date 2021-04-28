<?php

namespace UnknowG\WapyPractice\form\forms\wapass;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\MySQL;
use UnknowG\WapyPractice\form\api\CustomForm;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\task\BoostTask;
use UnknowG\WapyPractice\Wapy;

class BoostersForm{
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
                                if($p->getBoosters() >= 1){
                                    self::launchBooster($p);
                                }else{
                                    $p->sendMessage($p->translate("NO_BOOST"));
                                }
                                break;
                            case 1:
                                WapassHome::rewards($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle("Boosters");
            $form->setContent($p->translate("BOOSTERS_DESCRIPTION"));
            $form->addButton($p->translate("BOOSTERS"), 0, "textures/items/totem");
            $form->addButton($p->translate("WAPASS_REWARD_LIST"), 0, "textures/items/book_normal");
            $p->sendForm($form);
        }
    }

    public static function launchBooster(WAPlayer $p)
    {
        {
            $form = new CustomForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        MySQL::sendDB("UPDATE `gambler` SET `boosters`='".($p->getBoosters() - 1)."' WHERE name = '".$p->getName()."'");
                        $p->enableBoost();
                        Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new BoostTask($p,time() + 60 * (30 * $data[0])),20);
                    }
                }
            );

            $form->setTitle("Boosters");
            $form->addSlider($p->translate("BOOSTERS_COUNT_CHOOSE"),1,10);
            $p->sendForm($form);
        }
    }
}