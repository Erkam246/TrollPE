<?php

namespace ErkamKahriman\TrollPE\Tasks;

use ErkamKahriman\TrollPE\TrollPE;
use ErkamKahriman\TrollPE\Variable;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as C;

class TriggerTask extends Task {

    public function onRun(int $currentTick){
        foreach(TrollPE::getInstance()->getServer()->getOnlinePlayers() as $players){
            if($players->spawned){
                if(in_array($players->getName(), Variable::$TRIGERRED)){
                    $players->addTitle(C::OBFUSCATED."!!!".C::RESET.C::DARK_RED.C::BOLD."Triggered".C::WHITE.C::OBFUSCATED."!!!", C::BOLD."-----------");
                }
            }
        }
    }
}