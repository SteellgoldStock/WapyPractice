<?php

namespace UnknowG\WapyPractice\form\forms\friends;

use pocketmine\Server;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\CustomForm;
use UnknowG\WapyPractice\form\api\SimpleForm;
use UnknowG\WapyPractice\utils\Friends;
use UnknowG\WapyPractice\Wapy;

class FriendsForm extends SimpleForm{
    public static function open(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                self::add($p);
                                break;
                            case 1:
                                self::remove($p);
                                break;
                            case 2:
                                self::list($p);
                                break;
                            case 3:
                                $p2 = Server::getInstance()->getPlayer(Friends::$requests[$p->getName()]);
                                if($p2 instanceof WAPlayer){
                                    self::request($p,$p2);
                                }
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_FRIENDS_TITLE"));
            $form->setContent(str_replace(
                array("{COUNT}","{CONNECTED}","{DISCONNECTED}"),
                array(0,0,0),
                $p->translate("FORMS_FRIENDS_DESCRIPTION")
            ));
            $form->addButton($p->translate("FORMS_FRIENDS_ADD"),0,'textures/items/book_writable');
            $form->addButton($p->translate("FORMS_FRIENDS_REMOVE"),0,'textures/items/book_writable');
            $form->addButton($p->translate("FORMS_FRIENDS_LIST"),0,'textures/items/book_written');
            if(array_key_exists($p->getName(),Friends::$requests)){
                $form->addButton(str_replace("{NAME}",Friends::$requests[$p->getName()],$p->translate("FORMS_FRIENDS_ACCEPT")),0,'textures/items/book_portfolio');
            }
            $p->sendForm($form);
        }
    }

    public static function request(WAPlayer $p, WAPlayer $p2){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) use ($p2) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                $p2->sendMessage(str_replace("{NAME}",$p->getName(),$p->translate("FRIENDS_REQUEST_ACCEPTED")));
                                $p->sendMessage(str_replace("{NAME}",$p2->getName(),$p->translate("FRIENDS_REQUEST_ACCEPT")));
                                Friends::acceptRequest($p);
                                break;
                            case 1:
                                $p2->sendMessage(str_replace("{NAME}",$p->getName(),$p->translate("FRIENDS_REQUEST_DECLINED")));
                                $p->sendMessage(str_replace("{NAME}",$p2->getName(),$p->translate("FRIENDS_REQUEST_DECLINE")));
                                Friends::denyRequest($p);
                                break;
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_FRIENDS_TITLE"));
            $form->setContent($p->translate("FORMS_FRIENDS_CHOOSE"));
            $form->addButton($p->translate("FORMS_FRIENDS_CLAIM"),0,'textures/items/paper');
            $form->addButton($p->translate("FORMS_FRIENDS_DECLINE"),0,'textures/items/paper');
            $p->sendForm($form);
        }
    }

    public static function add(WAPlayer $p){
        {
            $form = new CustomForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                    } else {
                        $receiver = Server::getInstance()->getPlayer($data[0]);
                        if($receiver instanceof WAPlayer){
                            if(!$p->isFriend($receiver->getName())){
                                $p->sendMessage(str_replace("{NAME}",$receiver->getName(),$p->translate("FRIENDS_REQUEST_SEND")));
                                $receiver->sendMessage(str_replace("{NAME}",$p->getName(),$p->translate("FRIENDS_REQUEST_RECEIVED")));
                                Friends::sendRequest($p,$receiver);
                            }else{
                                $p->sendMessage(str_replace("{NAME}",$receiver->getName(),$p->translate("FRIENDS_ALREADY")));
                            }
                        }
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_FRIENDS_TITLE"));
            $form->addInput($p->translate("FORMS_FRIENDS_ADD_INPUT"));
            $p->sendForm($form);
        }
    }

    public static function list(WAPlayer $p){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) {
                    if ($data === null) {
                        self::open($p);
                    } else {
                        $name = array_values($p->getFriends())[$data];
                        self::info($p,$name);
                    }
                }
            );

            $form->setTitle($p->translate("FORMS_FRIENDS_TITLE"));
            $form->setContent($p->translate("FRIEND_CLICK_HELP"));
            foreach ($p->getFriends() as $friend){
                $form->addButton($friend);
            }
            $p->sendForm($form);
        }
    }

    public static function info(WAPlayer $p, String $name){
        {
            $form = new SimpleForm
            (
                function (WAPlayer $p, $data) use ($name){
                    if ($data === null) {
                        self::list($p);
                    } else {
                    }
                }
            );

            if(Server::getInstance()->getPlayer($name) instanceof WAPlayer){
                $status = $p->translate("FRIEND_CONNECTED");
            }else{
                $status = $p->translate("FRIEND_DISCONNECTED");
            }

            $form->setTitle($p->translate("FORMS_FRIENDS_TITLE"));
            $form->setContent(str_replace(
                array("{NAME}","{STATUS}"),
                array($name,$status),
                $p->translate("FRIEND_DESCRIPTION")
            ));
            $form->addButton($p->translate("FORMS_FRIENDS_REMOVE_FRIENDLIST"));
            $form->addButton($p->translate("FORMS_FRIENDS_INVITE_PARTY"));
            $p->sendForm($form);
        }
    }
}