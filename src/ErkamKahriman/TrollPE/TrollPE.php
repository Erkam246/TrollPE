<?php

namespace ErkamKahriman\TrollPE;

use ErkamKahriman\EventListener;
use ErkamKahriman\TrollPE\Tasks\TriggerTask;
use ErkamKahriman\TrollPE\Commands\TrollCommand;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class TrollPE extends PluginBase  {

    /** @var TrollPE $instance */
    private static $instance;

    public static $FREZZED = [];
    public static $TRIGERRED = [];

    public const PREFIX = "§bTrollPE §8» §f§r";

    public function onEnable(){
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("TrollPE", new TrollCommand($this));
        $this->getScheduler()->scheduleRepeatingTask(new TriggerTask(), 30);
    }

    public static function getInstance(): TrollPE{
        return self::$instance;
    }

    public function rocket(Player $player, int $power = 1){
        $player->setMotion(new Vector3(0, $power, 0));
    }

    public function blowup(Position $pos, int $radius = 1){
        $eplode = new Explosion($pos, $radius);
        $eplode->explodeB();
    }
}