<?php

namespace UnknowG\WapyPractice\task;

use pocketmine\scheduler\AsyncTask;
use UnknowG\WapyPractice\data\MySQL;

class DBAsyncTask extends AsyncTask {
    private $text;

    public function __construct(string $text){
        $this->text = $text;
    }

    public function onRun(){
        $db = MySQL::getData();
        $db->query($this->text);
        if ($db->error) throw new \Exception($db->error);
        $db->close();
    }
}