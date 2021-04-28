<?php

namespace UnknowG\WapyPractice\form\forms\games\category;

use pocketmine\level\Position;
use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\games\GamesForm;
use UnknowG\WapyPractice\managers\games\FILManager;
use UnknowG\WapyPractice\managers\games\GappleManager;
use UnknowG\WapyPractice\task\scoreboard\ScoreboardGame;
use UnknowG\WapyPractice\Wapy;

class RankedGamesForm extends SimpleForm{
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
                                GappleManager::addPlayer($p,true);
                                $p->teleport(new Position(261,4,257,Server::getInstance()->getLevelByName("gapple_ranked")));
                                Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardGame($p, true,"gapple_ranked","GAPPLE_RANKED"),20 * 10);
                                break;
                            case 1:
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_GAMES_PVP_RANKED_TITLE"));
            $form->setContent($p->translate("FORMS_GAMES_PVP_DESCRIPTION"));
            $form->addButton("Gapple (".GappleManager::getPlayers("gapple_ranked")." ". $p->translate("PLAYERS").")",0,'textures/items/apple_golden');
            $p->sendForm($form);
        }
    }
}