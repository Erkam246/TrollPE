<?php

namespace Erkam246;

use Erkam246\TrollPE\TrollPE;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

use function in_array;
use function array_search;

class EventListener implements Listener {

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        if(in_array($name, TrollPE::$FREZZED)){
            unset(TrollPE::$FREZZED[array_search($name, TrollPE::$FREZZED)]);
        }
        if(in_array($name, TrollPE::$TRIGERRED)){
            unset(TrollPE::$TRIGERRED[array_search($name, TrollPE::$TRIGERRED)]);
        }
    }
}