<?php

namespace ErkamKahriman\TrollPE\Commands;

use ErkamKahriman\TrollPE\TrollPE;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\types\CommandEnum;
use pocketmine\network\mcpe\protocol\types\CommandParameter;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class TrollCommand extends PluginCommand {

    public function __construct(TrollPE $plugin){
        parent::__construct("troll", $plugin);
        $this->setPermission("trollpe.command");
        if(TrollPE::getInstance()->getServer()->getName() == "Altay"){
            $args = ["chat", "rocket", "freeze", "trigger", "explode", "fakeop", "su"];
            $this->setParameters([
                new CommandParameter("arguments", CommandParameter::ARG_TYPE_STRING, false, new CommandEnum("args", $args)),
                new CommandParameter("player", CommandParameter::ARG_TYPE_TARGET, false)
            ]);
        }
        $this->setDescription("TrollPE Command.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if($sender instanceof Player && $sender->hasPermission("trollpe.command")){
            if(isset($args[0])){
                switch(strtolower($args[0])){
                    case "chat":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                if(isset($args[2])){
                                    unset($args[0], $args[1]);
                                    $msg = implode(" ", $args);
                                    if(!empty($msg)){
                                        $player->chat($msg);
                                    }
                                } else{
                                    $sender->sendMessage(TrollPE::PREFIX.C::GRAY."You forgot the Message.");
                                }
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "rocket":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                $multipler = intval($args[2]);
                                if(!empty($args[2]) && is_int($multipler)){
                                    TrollPE::getInstance()->rocket($player, $multipler);
                                } else{
                                    TrollPE::getInstance()->rocket($player);
                                }
                                $sender->sendMessage(TrollPE::PREFIX.C::RED.$player->getName().C::WHITE." is now in a rocket.");
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "freeze":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                if(!in_array($player->getName(), TrollPE::$FREZZED)){
                                    TrollPE::$FREZZED[] = $player->getName();
                                    $player->setImmobile(true);
                                    $sender->sendMessage(TrollPE::PREFIX.C::WHITE."You frezzed ".C::GREEN.$player->getName());
                                } else{
                                    unset(TrollPE::$FREZZED[array_search($player->getName(), TrollPE::$FREZZED)]);
                                    $player->setImmobile(false);
                                    $sender->sendMessage(TrollPE::PREFIX.C::RED."You unfrezzed ".C::GREEN.$player->getName());
                                }
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "trigger":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                if(!in_array($player->getName(), TrollPE::$TRIGERRED)){
                                    TrollPE::$TRIGERRED[] = $player->getName();
                                    $sender->sendMessage(TrollPE::PREFIX.C::WHITE."You triggered ".C::AQUA.$player->getName());
                                } else{
                                    unset(TrollPE::$TRIGERRED[array_search($player->getName(), TrollPE::$TRIGERRED)]);
                                    $sender->sendMessage(TrollPE::PREFIX.C::RED."You untriggered ".C::AQUA.$player->getName());
                                }
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "explode":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                $radius = intval($args[2]);
                                if(!empty($args[2]) && is_int($radius)){
                                    TrollPE::getInstance()->blowup($player, $args[2]);
                                } else{
                                    TrollPE::getInstance()->blowup($player);
                                }
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "fakeop":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                $sender->sendMessage(TrollPE::PREFIX."You fakeop't §e".$player->getName()."§r.");
                                $player->sendMessage("§7You are now op!");
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    case "su":
                        $pname = $args[1];
                        if(!empty($pname)){
                            $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                            if($player != null){
                                unset($args[0], $args[1]);
                                $cmd = implode(" ", $args);
                                TrollPE::getInstance()->getServer()->dispatchCommand($player, $cmd, true);
                                $sender->sendMessage(TrollPE::PREFIX."§7Run Command for §e".$player->getName()."§8: §r".$cmd);
                            } else{
                                $sender->sendMessage(TrollPE::PREFIX."Player not found.");
                            }
                        }
                        break;
                    default:
                        $this->sendHelp($sender);
                        break;
                }
            } else{
                $this->sendHelp($sender);
            }
        }
    }

    public function sendHelp(Player $player){
        $player->sendMessage(C::RED."/troll "."chat|rocket|freeze|trigger|explode|fakeop");
    }
}