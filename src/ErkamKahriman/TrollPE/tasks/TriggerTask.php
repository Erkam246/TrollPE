<?php

namespace ErkamKahriman\TrollPE\Tasks;

use ErkamKahriman\TrollPE\TrollPE;
use pocketmine\scheduler\Task;

class TriggerTask extends Task {

    public function onRun(int $currentTick){
        foreach(TrollPE::getInstance()->getServer()->getOnlinePlayers() as $players){
            if($players->spawned){
                if(in_array($players->getName(), TrollPE::$TRIGERRED)){
                    $players->addTitle("§k!!!§r§4§lTriggered§r§k!!!", "§kiejfushnihfpifgzhjlk");
                }
            }
        }
    }
}