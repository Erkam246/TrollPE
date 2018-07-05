<?php

namespace ErkamKahriman\TrollPE\Commands;

use ErkamKahriman\TrollPE\TrollPE;
use ErkamKahriman\TrollPE\Variable;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class TrollCommand extends PluginCommand {

    public function __construct(TrollPE $plugin){
        parent::__construct("troll", $plugin);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player && $sender->hasPermission("trollpe.command")){
            if(isset($args[0])){
                switch($args[0]){
                    case "chat":
                        if(!empty($args[1])){
                            $pname = $args[1];
                            if(!empty(TrollPE::getInstance()->getServer()->matchPlayer($pname))){
                                if(TrollPE::getInstance()->getServer()->matchPlayer($pname)[0]->isOnline()){
                                    $spieler = TrollPE::getInstance()->getServer()->matchPlayer($pname)[0];
                                    if(isset($args[2])){
                                        unset($args[0], $args[1]);
                                        $msg = implode(" ", $args);
                                        if(!empty($msg)){
                                            $spieler->chat($msg);
                                        }
                                    }
                                }
                            }
                        }
                        break;
                    case "rocket":
                        if(!empty($args[1])){
                            $pname = $args[1];
                            if(!empty(TrollPE::getInstance()->getServer()->matchPlayer($pname))){
                                if(TrollPE::getInstance()->getServer()->matchPlayer($pname)[0]->isOnline()){
                                    $spieler = TrollPE::getInstance()->getServer()->matchPlayer($pname)[0];
                                    if(!empty($args[2])){
                                        if(is_numeric($args[2])){
                                            TrollPE::getInstance()->rocket($spieler, $args[2]);
                                        }
                                    } else{
                                        TrollPE::getInstance()->rocket($spieler);
                                    }
                                    $sender->sendMessage(Variable::PREFIX.C::AQUA.$spieler->getName().C::WHITE." is now in a rocket.");
                                }
                            }
                        }
                        break;
                    case "freeze":
                        if(!empty($args[1])){
                            $pname = $args[1];
                            if(!empty(TrollPE::getInstance()->getServer()->matchPlayer($pname))){
                                if(TrollPE::getInstance()->getServer()->matchPlayer($pname)[0]->isOnline()){
                                    $spieler = TrollPE::getInstance()->getServer()->matchPlayer($pname)[0];
                                    if(!in_array($spieler->getName(), Variable::$FREZZED)){
                                        Variable::$FREZZED[] = $spieler->getName();
                                        $spieler->setImmobile(true);
                                        $sender->sendMessage(Variable::PREFIX.C::WHITE."You frezzed ".C::AQUA.$spieler->getName());
                                    } else{
                                        unset(Variable::$FREZZED[array_search($spieler->getName(), Variable::$FREZZED)]);
                                        $spieler->setImmobile(false);
                                        $sender->sendMessage(Variable::PREFIX.C::RED."You unfrezzed ".C::AQUA.$spieler->getName());
                                    }
                                }
                            }
                        }
                        break;
                    case "trigger":
                        if(!empty($args[1])){
                            $pname = $args[1];
                            if(!empty(TrollPE::getInstance()->getServer()->matchPlayer($pname))){
                                if(TrollPE::getInstance()->getServer()->matchPlayer($pname)[0]->isOnline()){
                                    $spieler = TrollPE::getInstance()->getServer()->matchPlayer($pname)[0];
                                    if(!in_array($spieler->getName(), Variable::$TRIGERRED)){
                                        Variable::$TRIGERRED[] = $spieler->getName();
                                        $sender->sendMessage(Variable::PREFIX.C::WHITE."You triggered ".C::AQUA.$spieler->getName());
                                    } else{
                                        unset(Variable::$TRIGERRED[array_search($spieler->getName(), Variable::$TRIGERRED)]);
                                        $sender->sendMessage(Variable::PREFIX.C::RED."You untrigered ".C::AQUA.$spieler->getName());
                                    }
                                }
                            }
                        }
                        break;
                    case "explode":
                        if(!empty($args[1])){
                            $pname = $args[1];
                            if(!empty(TrollPE::getInstance()->getServer()->matchPlayer($pname))){
                                if(TrollPE::getInstance()->getServer()->matchPlayer($pname)[0]->isOnline()){
                                    $spieler = TrollPE::getInstance()->getServer()->matchPlayer($pname)[0];
                                    if(!empty($args[2])){
                                        TrollPE::getInstance()->blowup($spieler, $args[2]);
                                    } else{
                                        TrollPE::getInstance()->blowup($spieler);
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        $this->sendHelp($sender);
                }
            } else{
                $this->sendHelp($sender);
            }
        }
    }

    public function sendHelp(Player $player){
        $player->sendMessage(C::RED."/troll "."chat|rocket|freeze|trigger|explode");
    }
}