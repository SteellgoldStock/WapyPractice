<?php

namespace UnknowG\WapyPractice\form\forms\games\category;

use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\games\GamesForm;
use UnknowG\WapyPractice\managers\games\FILManager;
use UnknowG\WapyPractice\managers\games\GappleManager;
use UnknowG\WapyPractice\managers\games\SumoManager;
use UnknowG\WapyPractice\task\scoreboard\ScoreboardGame;
use UnknowG\WapyPractice\Wapy;

class PvpGamesForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                        GamesForm::open($p);
                    } else {
                        switch ($data) {
                            case 0:
                                GappleManager::addPlayer($p,false);
                                Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardGame($p, false,"gapple","GAPPLE"),20 * 10);
                                break;
                            case 1:
                                SumoGameForm::open($p);
                                break;
                            case 2:
                                $p->ingame = "FIL";
                                FILManager::addPlayer($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_GAMES_PVP_TITLE"));
            $form->setContent($p->translate("FORMS_GAMES_PVP_DESCRIPTION"));
            $form->addButton("Gapple (".GappleManager::getPlayers("gapple")." ". $p->translate("PLAYERS").")",0,'textures/items/apple_golden');
            $form->addButton("Sumo (".SumoManager::getPlayers()." ". $p->translate("PLAYERS").")",0,'textures/items/wheat');
            $form->addButton("Floor Is Lava (".FILManager::getPlayers()." ". $p->translate("PLAYERS").")",0,'textures/items/bucket_lava');
            $p->sendForm($form);
        }
    }
}