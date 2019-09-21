<?php

namespace Erkam246\TrollPE\Tasks;

use Erkam246\TrollPE\TrollPE;
use pocketmine\scheduler\Task;

use function in_array;

class TriggerTask extends Task {

    public function onRun(int $currentTick){
        foreach(TrollPE::getMain()->getServer()->getOnlinePlayers() as $players){
            if($players->spawned){
                if(in_array($players->getName(), TrollPE::$TRIGERRED)){
                    $players->addTitle("§k!!!§r§4§lTriggered§r§k!!!", "§kiejfushnihfpifgzhjlk");
                }
            }
        }
    }
}