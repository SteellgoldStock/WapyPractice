<?php

namespace UnknowG\WapyPractice\form\forms\cosmetics;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\cosmetics\wapass\CosmeticsWPForm;

class CosmeticForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                CosmeticsWPForm::open($p);
                                break;
                            case 1:
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("COSMETICS"));
            $form->addButton("Animations de passage niveaux", 0, "textures/items/totem");
            $form->addButton("Tags", 0, "textures/items/paper");
            $form->addButton("Message de meurtres", 0, "textures/items/record_cat");
            $form->addButton("Animaux de compagnies", 0, "textures/items/egg");
            $form->addButton("Particules de dégats", 0, "textures/items/egg");
            $p->sendForm($form);
        }
    }
}