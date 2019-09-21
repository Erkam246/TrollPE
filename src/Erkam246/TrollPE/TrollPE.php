<?php

namespace Erkam246\TrollPE;

use Erkam246\EventListener;
use Erkam246\TrollPE\Tasks\TriggerTask;
use Erkam246\TrollPE\Commands\TrollCommand;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class TrollPE extends PluginBase {
    protected static $main;

    public static $FREZZED = [], $TRIGERRED = [];

    public const PREFIX = "§bTrollPE §8» §f§r";

    public function onEnable(){
        self::$main = $this;
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("TrollPE", new TrollCommand());
        $this->getScheduler()->scheduleRepeatingTask(new TriggerTask(), 30);
    }
    
    public static function getMain(): self{
        return self::$main;
    }

    public function rocket(Player $player, int $power = 1): void{
        $player->setMotion(new Vector3(0, $power, 0));
    }

    public function blowup(Position $pos, int $radius = 1): void{
        $eplode = new Explosion($pos, $radius);
        $eplode->explodeB();
    }
}