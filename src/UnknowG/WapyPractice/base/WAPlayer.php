<?php

namespace UnknowG\WapyPractice\base;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\OnScreenTextureAnimationPacket;
use pocketmine\Player;
use pocketmine\utils\Color;
use UnknowG\WapyPractice\data\Gambler;
use UnknowG\WapyPractice\data\MySQL;
use UnknowG\WapyPractice\langs\EN;
use UnknowG\WapyPractice\langs\FR;
use UnknowG\WapyPractice\utils\Animations;
use UnknowG\WapyPractice\utils\Friends;
use UnknowG\WapyPractice\utils\User;
use UnknowG\WapyPractice\Wapy;

class WAPlayer extends Player{

    public const SETTINGS = [
        "SHOW_OS"=>9,
        "PRIVATE_MESSAGE"=>10,
        "FRIEND_REQUEST"=>11,
        "FLY"=>12,
        "LEVEL_UP_ANIMATION"=>13,
        "TIMER_BOOST"=>14,
        "COMBAT_TIP"=>17,
        "LEVEL_UP_ANIMATION_CUSTOM"=>18
    ];

    public const LEAGUES = [
        0 => "Bronze",
        1 => "Iron",
        2 => "Gold",
        3 => "Diamond",
        4 => "Emerald",
        5 => "Enchanted Diamond",
        6 => "Enchanted Emerald",
        7 => "Obsidian",
        8 => "Enchanted Obsidian",
    ];

    public const LEAGUES_POINTS = [
        0 => 100,
        1 => 500,
        2 => 1000,
        3 => 1500,
        4 => 2000,
        5 => 2500,
        6 => 3000,
        7 => 3500,
        8 => 4000
    ];

    public $respawn = null;

    public $scorebard = true;

    public $lastTouch = null;
    public $combo = 0;

    public $ingame = null;

    private $os = null;

    public $lang = 'FR';

    public $wplevel = 0;
    public $wpxp = 0;
    public $asBoost = false;
    public $xpWithBoost = 0;

    public $gameStats = [
        "kills"=>null,
        "deaths"=>null,
        "lpoints"=>null,
    ];

    private $bossbar = null;

    /**
     * Return the rank
     */
    public function getRank() : string{
        return Gambler::getRank($this->username);
    }

    /**
     * Return the subrank
     */
    public function getSubRank() : string{
        return Gambler::getSubRank($this->username);
    }


    /**
     * Return the money
     */
    public function getMoney() : Int{
        return Gambler::getMoney($this->username);
    }

    /**
     * Return the time in expire the rank
     */
    public function getRankExpiration() : int{
        return Gambler::getRankExpiration($this->getName());
    }

    /**
     * Return 1 if the rank has an expiration and 0 if don't have
     */
    public function hasExpirationRank() : int{
        if($this->getRankExpiration() == 0){
            return 0;
        }else{
            return 1;
        }
    }

    /**
     * Return the langs of the player (FR, EN)
     */
    public function getLang() : string{
        return Gambler::getLang($this->username);
    }

    public function translate(String $textID){
        if($this->getLang() == "fr"){
            return FR::$tr[$textID];
        }else{
            return EN::$tr[$textID];
        }
    }

    /**
     * @param string $friend
     * @return bool
     */
    public function isFriend(string $friend) : bool{
        return Friends::isFriend($this->getName(), $friend);
    }

    /**
     * @param string $friend
     */
    public function removeFriend(string $friend){
        Friends::delFriend($this->getName(), $friend);
    }

    /**
     * @param string $friend
     */
    public function addFriend(string $friend){
        Friends::addFriend($this->getName(), $friend);
    }

    /**
     * @return array
     */
    public function getFriends() : array{
        return Friends::getFriend($this->getName());
    }

    public function getLeaguePoints() : int{
        return Gambler::getLeaguePoint($this->getName());
    }

    public function getLeague() : string{
        if($this->getLeaguePoints() >= 4000){
            return self::LEAGUES[8];
        }elseif($this->getLeaguePoints() >= 3500){
            return self::LEAGUES[7];
        }elseif($this->getLeaguePoints() >= 3000){
            return self::LEAGUES[6];
        }elseif($this->getLeaguePoints() >= 2500){
            return self::LEAGUES[5];
        }elseif($this->getLeaguePoints() >= 2000){
            return self::LEAGUES[4];
        }elseif($this->getLeaguePoints() >= 1500){
            return self::LEAGUES[3];
        }elseif($this->getLeaguePoints() >= 1000){
            return self::LEAGUES[2];
        }elseif($this->getLeaguePoints() >= 500){
            return self::LEAGUES[1];
        }elseif($this->getLeaguePoints() >= 100){
            return self::LEAGUES[0];
        }else{
            return "NR";
        }
    }

    public function getBoosters(){
        return Gambler::get($this->getName())[5];
    }

    public function addBoosters(Int $count = 1){
        $t = $this->getBoosters() + $count;
        MySQL::sendDB("UPDATE `gambler` SET `money`='".$t."' WHERE name = '".$this->getName()."'");
    }

    public function removeBoosters(Int $count = 1){
        $t = $this->getBoosters() - $count;
        MySQL::sendDB("UPDATE `gambler` SET `money`='".$t."' WHERE name = '".$this->getName()."'");
    }

    public function addMoney(Int $count){
        $t = $this->getMoney() + $count;
        MySQL::sendDB("UPDATE `gambler` SET `money`='".$t."' WHERE name = '".$this->getName()."'");
    }

    public function removeMoney(Int $count){
        $t = $this->getMoney() - $count;
        MySQL::sendDB("UPDATE `gambler` SET `money`='".$t."' WHERE name = '".$this->getName()."'");
    }

    public function getWPXP(){
        return Gambler::get($this->getName())[6];
    }

    public function getWPLevel(){
        return Gambler::get($this->getName())[7];
    }

    public function addWPXP(){

        if($this->asBoost()){
            $ex = mt_rand(25,50);
            $exp = $ex * 2;
            $this->xpWithBoost = $this->xpWithBoost + $ex;
            $msg = "TIP_BOOST_WAPASS_XP";
        }else{
            $exp = mt_rand(25,50);
            $msg = "TIP_WAPASS_XP";
        }

        $this->wpxp = $exp;
        $edit = $this->getWPXP() + $exp;
        MySQL::sendDB("UPDATE `gambler` SET `xp_pass`='".$edit."' WHERE name = '".$this->getName()."'");

        $this->sendPopup(str_replace(
            array("{LEVEL}","{EXP_SUPP}"),
            array($this->getWPLevelByXP(),$exp),
            $this->translate($msg)
        ));
    }

    public function asBoost() : bool {
        return $this->asBoost;
    }

    public function hasKey() : bool {
        if(Gambler::get($this->getName())[8] >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function getBoostXPWin() : bool {
        return $this->xpWithBoost;
    }

    public function addWPLevel(){
        $lvl = $this->getWPLevel() + 1;
        $this->wplevel = $lvl;
        MySQL::sendDB("UPDATE `gambler` SET `level_pass`='".$lvl."' WHERE name = '".$this->getName()."'");
    }

    public function getWPLevelByXP(){
        $level = $this->getWPLevel();
        $levelplus = $this->getWPLevel() + 1;
        if ($this->getWPXP() >= (($level * 2 * 100) - 100)) {
            $this->sendTitle("§l§9Wapy Pass","§f$level §l» §r§f$levelplus",10,5,10);

            if($this->getSettings("LEVEL_UP_ANIMATION") == 1 AND $this->getSettings("LEVEL_UP_ANIMATION") >= 1){
                $this->sendScreenAnimation($this->getSettings("LEVEL_UP_ANIMATION_CUSTOM"));
            }

            $this->addWPLevel();

            return $levelplus;
        }else{
            return $level;
        }
    }

    public function getRatio() : float {
        if($this->gameStats["kills"] == 0 && $this->gameStats["deaths"] == 0){
            return 0;
        }

        return round($this->gameStats["kills"] / ($this->gameStats["deaths"] !== 0 ? $this->gameStats["deaths"] : 1), 2);
    }

    public function giveInventory(String $world, Color $color = null){
        $this->getInventory()->setContents([]);
        $this->getArmorInventory()->setContents([]);
        $this->removeAllEffects();

        $inv = $this->getInventory();
        $armor = $this->getArmorInventory();
        $this->setHealth(20);
        $this->setFood(20);


        $this->getServer()->getLogger()->info("Giving the inventory $world for " . $this->getName());
        switch ($world){
            case "lobby":
                $inv->setItem(0,Item::get(ItemIds::ANVIL)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["SETTINGS"]." §9-"));
                $inv->setItem(1,Item::get(ItemIds::DIAMOND_HORSE_ARMOR)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["COSMETICS"]." §9-"));
                $inv->setItem(2,Item::get(ItemIds::TOTEM)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["FRIENDS"]." §9-"));
                $inv->setItem(4,Item::get(ItemIds::COMPASS)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["GAMES"]." §9-"));
                $inv->setItem(6,Item::get(ItemIds::MINECART_WITH_COMMAND_BLOCK)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["WAPASS"]." §9-"));
                $inv->setItem(7,Item::get(ItemIds::ENCHANTED_BOOK)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["STATS"]." §9-"));
                $inv->setItem(8,Item::get(ItemIds::NAME_TAG)->setCustomName("§9- §f".$this->translate("ITEMS_CUSTOM_NAMES")["PROFILE"]." §9-"));
                break;
            case "gapple":
                $protection = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
                $unbreaking = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
                $sharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 3);

                $helmet = Item::get(310);
                $helmet->addEnchantment($protection);
                $helmet->addEnchantment($unbreaking);
                $chestplate = Item::get(311);
                $chestplate->addEnchantment($protection);
                $chestplate->addEnchantment($unbreaking);
                $leggings = Item::get(312);
                $leggings->addEnchantment($protection);
                $leggings->addEnchantment($unbreaking);
                $boots = Item::get(313);
                $boots->addEnchantment($protection);
                $boots->addEnchantment($unbreaking);
                $sword = Item::get(276);
                $sword->addEnchantment($sharpness);
                $sword->addEnchantment($unbreaking);
                $gapples = Item::get(322)->setCount(5);

                $armor->setItem(0, $helmet);
                $armor->setItem(1, $chestplate);
                $armor->setItem(2, $leggings);
                $armor->setItem(3, $boots);

                $sword->addEnchantment($sharpness);
                $sword->addEnchantment($unbreaking);

                $inv->setItem(0,$sword);
                $inv->setItem(1,$gapples);
                break;
            case "fil":
                $knockback = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::KNOCKBACK), 2);
                // $aqua =  new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 1);

                $helmet = Item::get(298);
                $helmet->setCustomColor(new Color(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
                $chestplate = Item::get(299);
                $chestplate->setCustomColor(new Color(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
                $leggings = Item::get(300);
                $leggings->setCustomColor(new Color(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
                $boots = Item::get(301);
                $boots->setCustomColor(new Color(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));

                $this->getArmorInventory()->setHelmet($helmet);
                $this->getArmorInventory()->setChestplate($chestplate);
                $this->getArmorInventory()->setLeggings($leggings);
                $this->getArmorInventory()->setBoots($boots);

                $this->getInventory()->setContents([]);
                $stick = Item::get(ItemIds::STICK);
                $stick->addEnchantment($knockback);
                // $enderpearl = Item::get(ItemIds::ENDER_PEARL);
                // $enderpearl->addEnchantment($aqua);
                $this->getInventory()->setItem(0,$stick);
                // $this->getInventory()->setItem(1,$enderpearl);
                break;
            case "sumo":
                $helmet = Item::get(298);
                $helmet->setCustomColor($color);
                $chestplate = Item::get(299);
                $chestplate->setCustomColor($color);
                $leggings = Item::get(300);
                $leggings->setCustomColor($color);
                $boots = Item::get(301);
                $boots->setCustomColor($color);

                $this->getArmorInventory()->setHelmet($helmet);
                $this->getArmorInventory()->setChestplate($chestplate);
                $this->getArmorInventory()->setLeggings($leggings);
                $this->getArmorInventory()->setBoots($boots);
                break;
        }
    }

    public function enableBoost(){
        $this->asBoost = true;
        $this->xpWithBoost = 0;
    }

    public function disableBoost(){
        $this->asBoost = false;
        $this->xpWithBoost = 0;
    }

    public function sendGuardian(){
        $pk = new LevelEventPacket();
        $pk->evid = LevelEventPacket::EVENT_GUARDIAN_CURSE;
        $pk->data = 0;
        $pk->position = $this->asVector3();
        $this->dataPacket($pk);
    }

    public function sendScreenAnimation(int $animationType) {
        $pk = new OnScreenTextureAnimationPacket();

        if($animationType == 25) $pk->effectId = 26; else $pk->effectId = $animationType;
        $this->sendDataPacket($pk);
    }

    public function getOs(): ?string{
        return User::OS_LIST[Wapy::$deviceOS[$this->getName()]];
    }

    public function showOs(): string{
        if(Gambler::get($this->getName())[9] == 1){
            return $this->getOs();
        }else{
            return "/";
        }
    }

    public function getSettings(String $setting) : Int{
        return Gambler::getSettings($setting,$this->getName());
    }

    public function getCosmetics(String $id) : Int{
        return Gambler::getCosmetics($id,$this->getName());
    }

    public function getSettingsStatus(String $setting): string{
        if($this->getSettings($setting) == 1){
            return $this->translate("SETTINGS_ON")."§f";
        }else{
            return $this->translate("SETTINGS_OFF")."§f";
        }
    }

    public function getAnimationIsChoose(Int $effectId): string{
        if($this->getSettings("LEVEL_UP_ANIMATION_CUSTOM") == $effectId){
            return "textures/gui/newgui/buttons/checkbox/checkboxFilledWhiteBorder";
        }else{
            return "textures/gui/newgui/buttons/checkbox/checkboxUnFilled_WhiteBorder";
        }
    }

    public function getCosmeticStatus(String $cosmeticId): string{
        if($this->getCosmetics($cosmeticId) == 1){
            return $this->translate("HAVE");
        }else{
            return $this->translate("NOT_HAVE");
        }
    }

    public function setRank(String $toSet, Int $expiration, String $rank) {
        MySQL::sendDB("UPDATE `gambler` SET `rank`='".$toSet."',`rank_expire`='".$expiration."',`subRank`='".$rank."' WHERE name = '".$this->getName()."'");
    }

    public function setRankReward(String $toSet, Int $expiration, String $rank) {
        if(!$this->getRankExpiration() == 0){
            MySQL::sendDB("UPDATE `gambler` SET `rank`='".$toSet."',`rank_expire`='".$expiration."' WHERE name = '".$this->getName()."'");
        }else{
            MySQL::sendDB("UPDATE `gambler` SET `rank`='".$toSet."',`rank_expire`='".$expiration."',`subRank`='".$rank."', WHERE name = '".$this->getName()."'");
        }
    }
}