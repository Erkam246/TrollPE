<?php

namespace ErkamKahriman\TrollPE;

use ErkamKahriman\TrollPE\Tasks\TriggerTask;
use ErkamKahriman\TrollPE\Commands\TrollCommand;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\level\Explosion;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class TrollPE extends PluginBase implements Listener {

    /** @var TrollPE $instance */
    public static $instance;

    public static $FREZZED = [];
    public static $TRIGERRED = [];

    public const PREFIX = C::AQUA."TrollPE".C::DARK_GRAY." > ".C::RESET;

    public function onEnable() {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("TrollPE", new TrollCommand($this));
        $this->getScheduler()->scheduleRepeatingTask(new TriggerTask(), 30);
    }

    public static function getInstance() : TrollPE{
        return self::$instance;
    }

    public function rocket(Player $player, int $power = 1){
        $player->setMotion(new Vector3(0, $power, 0));
    }

    public function blowup(Player $player, int $radius = 1){
        $eplode = new Explosion($player->getPosition(), $radius);
        $eplode->explodeB();
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        if (in_array($name, TrollPE::$FREZZED)){
            unset(TrollPE::$FREZZED[array_search($name, TrollPE::$FREZZED)]);
        }
        if(in_array($name, TrollPE::$TRIGERRED)){
            unset(TrollPE::$TRIGERRED[array_search($name, TrollPE::$TRIGERRED)]);
        }
    }
}