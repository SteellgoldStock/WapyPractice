<?php

namespace UnknowG\WapyPractice\form\forms\cosmetics\wapass;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\data\Gambler;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\utils\Animations;
use UnknowG\WapyPractice\utils\Cosmetics;

class CosmeticsWPForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        $eff = array_values(Animations::effects)[$data];

                        if(in_array($eff,Cosmetics::CAN_BUY_IG)){
                            if($p->getCosmetics(Cosmetics::E[$eff]) == 1){
                                $p->sendMessage(str_replace("{EFFECT}","%potion.".str_replace("e_","",Cosmetics::E[$eff]),$p->translate("EFFECT_APPLY")));
                                Gambler::edit("setting_animationCustom",$eff,$p->getName());
                            }else{
                                self::buy($p,$eff,"%potion.".str_replace("e_","",Cosmetics::E[$eff]),Cosmetics::E[$eff]);
                            }
                        }elseif($p->getCosmetics(Cosmetics::E[$eff]) == 1){
                            $p->sendMessage(str_replace("{EFFECT}","%potion.".str_replace("e_","",Cosmetics::E[$eff]),$p->translate("EFFECT_APPLY")));
                            Gambler::edit("setting_animationCustom",$eff,$p->getName());
                        }else{
                            $p->sendMessage(str_replace("{EFFECT}","%potion.".str_replace("e_","",Cosmetics::E[$eff]),$p->translate("EFFECT_BUY_STORE")));
                        }
                    }
                }
            );

            $form->setTitle($p->translate("COSMETICS"));
            $form->setContent("Cliquez pour appliquer");
            $form->addButton("%potion.moveSpeed \n".$p->getCosmeticStatus("e_moveSpeed"),0,$p->getAnimationIsChoose(Animations::SPEED));
            $form->addButton("%potion.moveSlowdown \n".$p->getCosmeticStatus("e_moveSlowdown"),0,$p->getAnimationIsChoose(Animations::SLOWNESS));
            $form->addButton("%potion.digSpeed \n".$p->getCosmeticStatus("e_digSpeed"),0,$p->getAnimationIsChoose(Animations::HASTE));
            $form->addButton("%potion.digSlowDown \n".$p->getCosmeticStatus("e_digSlowDown"),0,$p->getAnimationIsChoose(Animations::FATIGUE));
            $form->addButton("%potion.damageBoost \n".$p->getCosmeticStatus("e_damageBoost"),0,$p->getAnimationIsChoose(Animations::STRENGTH));
            $form->addButton("%potion.heal \n".$p->getCosmeticStatus("e_heal"),0,$p->getAnimationIsChoose(Animations::HEALTH_BOOST));
            $form->addButton("%potion.harm \n".$p->getCosmeticStatus("e_harm"),0,$p->getAnimationIsChoose(Animations::DAMAGE_RESISTANCE));
            $form->addButton("%potion.jump \n".$p->getCosmeticStatus("e_jump"),0,$p->getAnimationIsChoose(Animations::JUMP));
            $form->addButton("%potion.confusion \n".$p->getCosmeticStatus("e_confusion"),0,$p->getAnimationIsChoose(Animations::NAUSEA));
            $form->addButton("%potion.regeneration \n".$p->getCosmeticStatus("e_regeneration"),0,$p->getAnimationIsChoose(Animations::REGENERATION));
            $form->addButton("%potion.resistance \n".$p->getCosmeticStatus("e_resistance"),0,$p->getAnimationIsChoose(Animations::RESISTANCE));
            $form->addButton("%potion.fireResistance \n".$p->getCosmeticStatus("e_fireResistance"),0,$p->getAnimationIsChoose(Animations::FIRE_RESISTANCE));
            $form->addButton("%potion.waterBreathing \n".$p->getCosmeticStatus("e_waterBreathing"),0,$p->getAnimationIsChoose(Animations::WATER_BREATHING));
            $form->addButton("%potion.invisibility \n".$p->getCosmeticStatus("e_invisibility"),0,$p->getAnimationIsChoose(Animations::INVISIBILITY));
            $form->addButton("%potion.blindness \n".$p->getCosmeticStatus("e_blindness"),0,$p->getAnimationIsChoose(Animations::BLINDNESS));
            $form->addButton("%potion.nightVision \n".$p->getCosmeticStatus("e_nightVision"),0,$p->getAnimationIsChoose(Animations::NIGHT_VISION));
            $form->addButton("%potion.hunger \n".$p->getCosmeticStatus("e_hunger"),0,$p->getAnimationIsChoose(Animations::HUNGER));
            $form->addButton("%potion.weakness \n".$p->getCosmeticStatus("e_weakness"),0,$p->getAnimationIsChoose(Animations::WEAKNESS));
            $form->addButton("%potion.poison \n".$p->getCosmeticStatus("e_poison"),0,$p->getAnimationIsChoose(Animations::POISON));
            $form->addButton("%potion.wither \n".$p->getCosmeticStatus("e_wither"),0,$p->getAnimationIsChoose(Animations::WITHER));
            $form->addButton("%potion.healthBoost \n".$p->getCosmeticStatus("e_healthBoost"),0,$p->getAnimationIsChoose(Animations::HEALTH_BOOST));
            $form->addButton("%potion.absorption \n".$p->getCosmeticStatus("e_absorption"),0,$p->getAnimationIsChoose(Animations::ABSORPTION));
            $form->addButton("%potion.saturation \n".$p->getCosmeticStatus("e_saturation"),0,$p->getAnimationIsChoose(Animations::SATURATION));
            $form->addButton("%potion.levitation \n".$p->getCosmeticStatus("e_levitation"),0,$p->getAnimationIsChoose(Animations::LEVITATION));
            $form->addButton("%potion.conduitPower \n".$p->getCosmeticStatus("e_conduitPower"),0,$p->getAnimationIsChoose(Animations::CONDUIT_POWER));

            $p->sendForm($form);
        }
    }

    public static function buy(WAPlayer $p, Int $id, String $n, string $d){
        {
            $form = new SimpleForm(
                function (WAPlayer $p, $data) use ($id, $n, $d) {
                    if ($data === null) {
                    } else{
                        switch ($data){
                            case 0:
                                if($p->getMoney() >= 1000){
                                    $p->sendMessage(str_replace("{EFFECT}",$n,$p->translate("EFFECT_BUY")));
                                    Gambler::edit("setting_animationCustom",$id,$p->getName());
                                    Gambler::editOther("cosmetics",$d,1,$p->getName());
                                    $p->removeMoney(1000);
                                }else{
                                    $p->sendMessage(str_replace("{MORE}",1000 - $p->getMoney(),$p->translate("MONEY_MORE")));
                                }
                                break;
                            case 1:
                                $p->sendScreenAnimation($id);
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("COSMETICS"));
            $form->setContent(str_replace("{EFFECT}",$n,$p->translate("EFFECT_BUY_TEXT")));
            $form->addButton($p->translate("BUY"));
            $form->addButton($p->translate("TEST"));
            $p->sendForm($form);
        }
    }
}

























