<?php

namespace UnknowG\WapyPractice\task\scoreboard;

use pocketmine\scheduler\Task;
use UnknowG\WapyPractice\base\WAPlayer;
use UnknowG\WapyPractice\managers\Text;
use UnknowG\WapyPractice\modules\Scoreboard;
use UnknowG\WapyPractice\Wapy;

class ScoreboardGame extends Task {
    public $player;
    public $ranked;
    public $worldName;
    public $gameName;

    public function __construct(WAPlayer $player, $ranked,$worldName,$gameName){
        $this->player = $player;
        $this->ranked = $ranked;
        $this->worldName = $worldName;
        $this->gameName = $gameName;
    }

    public function onRun(int $currentTick){
        if($this->player->isOnline() && $this->player->getLevel()->getName() == $this->worldName && $this->player->scorebard == true){
            Scoreboard::remove($this->player);
            Scoreboard::new($this->player,"GappleObjective","  §f- §l§f".Text::GAMES_SB[$this->gameName]." §f-  ");
            Scoreboard::setLine($this->player,1," ");
            Scoreboard::setLine($this->player,2,"  §f".$this->player->translate("KILLS").": §9".$this->player->gameStats["kills"] . "  ");
            Scoreboard::setLine($this->player,3,"  §f".$this->player->translate("DEATHS").": §9".$this->player->gameStats["deaths"] . "  ");
            Scoreboard::setLine($this->player,4,"  §f".$this->player->translate("RATIO").": §9". $this->player->getRatio() . "  ");
            Scoreboard::setLine($this->player,5,"     ");
            if($this->ranked == true){
                Scoreboard::setLine($this->player,6,"  §f".$this->player->translate("RANKED").": §9".$this->player->translate("REPLAY_YES") . "  ");
            }else{
                Scoreboard::setLine($this->player,6,"  §f".$this->player->translate("RANKED").": §9".$this->player->translate("REPLAY_NO") . "  ");
            }
            Scoreboard::setLine($this->player,7,"   ");
            Scoreboard::setLine($this->player,8,"  §f".$this->player->translate("STATS_OF")."  ");
            Scoreboard::setLine($this->player,9,"  §f".$this->player->translate("THIS_GAME")."  ");
            Scoreboard::setLine($this->player,10,"  ");
            Scoreboard::setLine($this->player,11,"  §fwapy.fr  ");
            Scoreboard::setLine($this->player,12,"     ");
        }else{
            Scoreboard::remove($this->player);
            Wapy::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}