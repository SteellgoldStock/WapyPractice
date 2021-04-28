<?php

namespace UnknowG\WapyPractice\form\forms\games\category;

use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\utils\Color;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\form\forms\games\GamesForm;
use UnknowG\WapyPractice\managers\games\FILManager;
use UnknowG\WapyPractice\managers\games\GappleManager;
use UnknowG\WapyPractice\managers\games\SumoManager;
use UnknowG\WapyPractice\task\games\GameIsFull;
use UnknowG\WapyPractice\task\scoreboard\ScoreboardGame;
use UnknowG\WapyPractice\Wapy;

class SumoGameForm extends SimpleForm{
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
                                if(SumoManager::$sumo1 == 1){
                                    SumoManager::$sumo1++;
                                    SumoManager::addWainting($p,"sumo1","blue");
                                    SumoManager::launchGame(Server::getInstance()->getLevelByName("sumo1"));
                                }elseif(SumoManager::$sumo1 == 0){
                                    SumoManager::$sumo1++;
                                    SumoManager::addWainting($p,"sumo1","red");
                                }else{
                                    $p->sendMessage("Plein");
                                }
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_GAMES_PVP_TITLE"));
            $form->addButton("Jungle Birds §l#1§r");
            $form->addButton("Jungle Birds §l#2§r");
            $form->addButton("Aquatic Sinkhole §l#1§r");
            $form->addButton("Aquatic Sinkhole §l#2§r");
            $form->addButton("Forest Sinkhole §l#1§r");
            $form->addButton("Forest Sinkhole §l#2§r");
            $p->sendForm($form);
        }
    }
}