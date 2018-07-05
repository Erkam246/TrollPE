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

    private static $instance;

    public function onEnable() {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("TrollPE", new TrollCommand($this));
        $troll = $this->getCommand("troll");
        $troll->setPermission("trollpe.command");
        $troll->setDescription("TrollPE Command");
        $this->getScheduler()->scheduleRepeatingTask(new TriggerTask(), 35);
        $this->getLogger()->info(C::GREEN."Aktiviert.");
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
        if (in_array($name, Variable::$FREZZED)){
            unset(Variable::$FREZZED[array_search($name, Variable::$FREZZED)]);
        }
        if(in_array($name, Variable::$TRIGERRED)){
            unset(Variable::$TRIGERRED[array_search($name, Variable::$TRIGERRED)]);
        }
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED."Deaktiviert.");
    }
}