<?php

namespace UnknowG\WapyPractice\form\forms\player;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\ModalForm;
use UnknowG\WapyPractice\form\api\SimpleForm;

class LobbyForm extends SimpleForm{
    public static function open(WAPlayer $p){{
            $form = new ModalForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 1:
                                $p->transfer("wapy.fr");
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("LOBBY_RETURN"));
            $form->setContent(str_replace("{SERVER}","Practice",$p->translate("LOBBY_RETURN_QUESTION")));
            $form->setButton1($p->translate("REPLAY_YES"));
            $form->setButton2($p->translate("REPLAY_NO"));
            $p->sendForm($form);
        }
    }
}