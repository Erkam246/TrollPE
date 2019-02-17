<?php

/**
 * Created by PhpStorm.
 * User: Erkam
 * Date: 17.02.2019
 * Time: 22:28
 */

namespace ErkamKahriman;

use ErkamKahriman\TrollPE\TrollPE;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener {

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $name = $player->getName();
        if(in_array($name, TrollPE::$FREZZED))
            unset(TrollPE::$FREZZED[array_search($name, TrollPE::$FREZZED)]);
        if(in_array($name, TrollPE::$TRIGERRED))
            unset(TrollPE::$TRIGERRED[array_search($name, TrollPE::$TRIGERRED)]);
    }
}