<?php

namespace ErkamKahriman\TrollPE\Commands;

use ErkamKahriman\TrollPE\TrollPE;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\CommandEnum;
use pocketmine\network\mcpe\protocol\types\CommandParameter;
use pocketmine\Player;

class TrollCommand extends PluginCommand {

    public function __construct(TrollPE $plugin){
        parent::__construct("troll", $plugin);
        $this->setPermission("trollpe.command");
        if(TrollPE::getInstance()->getServer()->getName() === "Altay"){
            $params = ["chat", "rocket", "freeze", "trigger", "explode", "fakeop", "su"];
            $this->setParameters([
                new CommandParameter("args", AvailableCommandsPacket::ARG_TYPE_STRING, false, new CommandEnum("args", $params)),
                new CommandParameter("player", AvailableCommandsPacket::ARG_TYPE_TARGET, false)
            ]);
        }
        $this->setDescription("TrollPE Command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage(TrollPE::PREFIX."§cThis command is only available in-game");
            return false;
        }
        if(!isset($args[0])){
            $this->sendHelp($sender);
            return false;
        }
        switch(strtolower($args[0])){
            case "chat":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        if(isset($args[2])){
                            unset($args[0], $args[1]);
                            $msg = implode(" ", $args);
                            if(!empty($msg)){
                                $player->chat($msg);
                            }
                        } else{
                            $sender->sendMessage(TrollPE::PREFIX."§7You forgot the Message.");
                        }
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "rocket":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        $multipler = (int) $args[2];
                        if(isset($args[2]) && is_int($multipler)){
                            TrollPE::getInstance()->rocket($player, $multipler);
                        } else{
                            TrollPE::getInstance()->rocket($player);
                        }
                        $sender->sendMessage(TrollPE::PREFIX."§c".$player->getName()." §fis now in a rocket.");
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "freeze":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        if(!in_array($player->getName(), TrollPE::$FREZZED)){
                            TrollPE::$FREZZED[] = $player->getName();
                            $player->setImmobile();
                            $sender->sendMessage(TrollPE::PREFIX."§fYou frezzed §a".$player->getName());
                        } else{
                            unset(TrollPE::$FREZZED[array_search($player->getName(), TrollPE::$FREZZED)]);
                            $player->setImmobile(false);
                            $sender->sendMessage(TrollPE::PREFIX."§cYou unfrezzed §a".$player->getName());
                        }
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "trigger":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        if(!in_array($player->getName(), TrollPE::$TRIGERRED)){
                            TrollPE::$TRIGERRED[] = $player->getName();
                            $sender->sendMessage(TrollPE::PREFIX."§fYou triggered §b".$player->getName());
                        } else{
                            unset(TrollPE::$TRIGERRED[array_search($player->getName(), TrollPE::$TRIGERRED)]);
                            $sender->sendMessage(TrollPE::PREFIX."§cYou untriggered §b".$player->getName());
                        }
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "explode":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        $radius = (int) $args[2];
                        if(isset($args[2]) && is_int($radius)){
                            TrollPE::getInstance()->blowup($player->getPosition(), $radius);
                        } else{
                            TrollPE::getInstance()->blowup($player->getPosition());
                        }
                        $sender->sendMessage(TrollPE::PREFIX."§eBlowed up §c".$player->getName());
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "fakeop":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        $sender->sendMessage(TrollPE::PREFIX."You fakeop't §e".$player->getName());
                        $player->sendMessage("§7You are now op!");
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            case "su":
                $pname = $args[1];
                if(!empty($pname)){
                    $player = TrollPE::getInstance()->getServer()->getPlayer($pname);
                    if($player !== null){
                        unset($args[0], $args[1]);
                        $cmd = implode(" ", $args);
                        TrollPE::getInstance()->getServer()->dispatchCommand($player, $cmd, true);
                        $sender->sendMessage(TrollPE::PREFIX."§7Run Command for §a".$player->getName()."§8: §r".$cmd);
                    } else{
                        $sender->sendMessage(TrollPE::PREFIX."§cPlayer not found.");
                    }
                }
                break;
            default:
                $this->sendHelp($sender);
                break;
        }
        return true;
    }

    private function sendHelp(Player $player){
        $player->sendMessage("§c/troll chat|rocket|freeze|trigger|explode|fakeop|su");
    }
}