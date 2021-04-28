<?php

namespace UnknowG\WapyPractice;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use UnknowG\WapyPractice\commands\defaults\RankExpirationCommand;
use UnknowG\WapyPractice\commands\defaults\WapassCommand;
use UnknowG\WapyPractice\commands\staff\ManageCommand;
use UnknowG\WapyPractice\commands\staff\NPCCommand;
use UnknowG\WapyPractice\commands\vanilla\GamemodeCommand;
use UnknowG\WapyPractice\commands\vanilla\LeaveCommand;
use UnknowG\WapyPractice\commands\vanilla\ListCommand;
use UnknowG\WapyPractice\commands\vanilla\SpawnCommand;
use UnknowG\WapyPractice\commands\vanilla\TellCommand;
use UnknowG\WapyPractice\data\MySQL;
use UnknowG\WapyPractice\entity\npc\BoxNPC;
use UnknowG\WapyPractice\entity\npc\LobbyNPC;
use UnknowG\WapyPractice\listener\games\FILListener;
use UnknowG\WapyPractice\listener\games\GappleListener;
use UnknowG\WapyPractice\listener\games\SumoListener;
use UnknowG\WapyPractice\listener\ItemsListener;
use UnknowG\WapyPractice\listener\PlayerListener;
use UnknowG\WapyPractice\managers\Ranks;
use UnknowG\WapyPractice\task\player\PlayerNameTag;

class Wapy extends PluginBase implements Listener {

    /**
     * @var self
     */
    public static $instance;

    public static $deviceOS;

    public static $path = 'plugins/WapyPractice/src/UnknowG/WapyPractice/resources';

    public function onEnable(){
        self::$instance = $this;

        $this->getServer()->getPluginManager()->registerEvents($this,$this);

        $this->getLogger()->info(" __          __                 _____                _   _          ");
        $this->getLogger()->info(" \ \        / /                |  __ \              | | (_)         ");
        $this->getLogger()->info("  \ \  /\  / /_ _ _ __  _   _  | |__) | __ __ _  ___| |_ _  ___ ___ ");
        $this->getLogger()->info("   \ \/  \/ / _` | '_ \| | | | |  ___/ '__/ _` |/ __| __| |/ __/ _ \ ");
        $this->getLogger()->info("    \  /\  / (_| | |_) | |_| | | |   | | | (_| | (__| |_| | (_|  __/");
        $this->getLogger()->info("     \/  \/ \__,_| .__/ \__, | |_|   |_|  \__,_|\___|\__|_|\___\___|");
        $this->getLogger()->info("                 |_|    |___/                                       ");
        $this->getLogger()->info("- Developped by Gaëtan");

        MySQL::init();

        $ranks = new Ranks();
        $ranks->init();

        $this->loadEntities();
        $this->loadCommands();
        $this->loadTasks();
        $this->loadListeners();

        Server::getInstance()->loadLevel("FIL_1");
        Server::getInstance()->loadLevel("FIL_2");
        Server::getInstance()->loadLevel("gapple");
        Server::getInstance()->loadLevel("gapple_ranked");
        Server::getInstance()->loadLevel("lobby");
        Server::getInstance()->loadLevel("sumo1");
        Server::getInstance()->loadLevel("sumo2");
        Server::getInstance()->loadLevel("sumo3");
        Server::getInstance()->loadLevel("sumo4");
        Server::getInstance()->loadLevel("sumo5");
        Server::getInstance()->loadLevel("sumo6");
        Server::getInstance()->loadLevel("sumo7");
        Server::getInstance()->loadLevel("sumo8");
        Server::getInstance()->loadLevel("sumo9");
        Server::getInstance()->loadLevel("sumo10");
    }

    public function onDisable(){
        foreach(Server::getInstance()->getOnlinePlayers() as $player){
            $player->transfer("direct.justaven.xyz",19132);
        }
    }

    /**
     * @return mixed
     */
    public static function getInstance() : Wapy{
        return self::$instance;
    }

    public function loadEntities(){
        Entity::registerEntity(LobbyNPC::class,true);
        Entity::registerEntity(BoxNPC::class,true);
    }

    public function loadCommands(){
        $this->getServer()->getCommandMap()->registerAll("Wapy", [
                new NPCCommand("npc","Faire apparaître un NPC à votre position",null,["pnj"]),
                new ManageCommand("manage","Réaliser des actions sur le serveur ou des joueurs",null,["mng"]),
                new TellCommand("tell","Envoyer un message à un autre joueur",null,["msg"]),
                new RankExpirationCommand("expiration","Voir l'état d'expiration de votre grade",null,["rankexpiration"]),
                new SpawnCommand("spawn","Retourner au spawn du serveur"),
                new LeaveCommand("leave","Quitter le mode de jeux ou vous vous trouvez"),
                new ListCommand("list","Voir la liste des joueurs connecté(e)s",null,["players"]),
                new GamemodeCommand("gamemode","Modifier votre mode de jeu",null,["gm"]),
                new WapassCommand("pass","Voir le status de votre Wapy Pass",null,["wapass","wapypass"]),
            ]
        );
    }

    public function loadListeners(){
        new PlayerListener();
        new ItemsListener();
        new GappleListener();
        new FILListener();
        new SumoListener();
    }

    public function loadTasks(){
        Wapy::getInstance()->getScheduler()->scheduleRepeatingTask(new PlayerNameTag(),20);
    }

    public static function getResourcesPath(){
        return self::$path;
    }

    public function onPacketReceived(DataPacketReceiveEvent $receiveEvent) {
        $pk = $receiveEvent->getPacket();
        if($pk instanceof LoginPacket) {
            self::$deviceOS[$pk->username] = $pk->clientData["DeviceOS"];
        }
    }
}