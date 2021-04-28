<?php

namespace UnknowG\WapyPractice\form\forms\player;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;

class ManagerForm {
    public static function open(WAPlayer $p){{
        $form = new SimpleForm
        (
            function (WAPlayer $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 1:
                            break;
                    }
                }
            }
        );

        $form->setTitle("Gérer le serveur");
        $form->addButton("Modifier un joueur",0,"textures/wapy/forms/settings");
        $form->addButton("Voir les activitées d'un joueur",0,"textures/wapy/forms/logs");
        $form->addButton("Trouver des joueurs avec même IP",0,"textures/wapy/forms/compass");
        $form->addButton("Modifier les jeux",0,"textures/wapy/forms/games_manage");
        $form->addButton("Modifier le serveur",0,"textures/wapy/forms/server_manage");
        $form->addButton("Crée un objectif",0,"textures/wapy/forms/objective");
        $p->sendForm($form);
    }
    }
}