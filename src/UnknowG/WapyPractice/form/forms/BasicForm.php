<?php

namespace UnknowG\WapyPractice\form\forms;

use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\form\api\SimpleForm;

class BasicForm
{

    public $data;
    public $player;

    public function __construct(WAPlayer $player, string $title, string $start, array $content)
    {
        $this->data["title"] = $title;
        $this->data["start"] = $start;
        $c = "";
        foreach ($content as $value){
            $c .= "\n" . $value;
        }
        $this->data["content"] = $c;
        $this->player = $player;
    }

    public function send(){
        $form = new SimpleForm(
            function (WAPlayer $p, $data) {
                if ($data === null) return;
            }
        );

        $form->setTitle($this->data["title"]);
        $form->setContent($this->data["start"].$this->data["content"]);
        $this->player->sendForm($form);
    }
}