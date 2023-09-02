<?php

namespace RenameMaster\command;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use RenameMaster\Loader;

class RenameCommand extends VanillaCommand {


    public function __construct()
    {
        $config = Loader::getIntance()->getConfig();

        parent::__construct($config->get("command_name"), $config->get("command_description"));
        $this->setPermission("rename.command.use");
    }

    public function execute(CommandSender $s, string $label, array $args)
    {

        $config = Loader::getIntance()->getConfig();

        if (!$s instanceof Player) {
            $s->sendMessage(str_replace(["&"], ["§"], $config->get("only_player")));
            return;
        }

        if (!$this->testPermission($s) && $s->hasPermission(DefaultPermissions::ROOT_OPERATOR)) {
            $s->sendMessage(str_replace(["&"], ["§"], $config->get("need_permission")));
            return;
        }

        if(empty($args)) {
            $s->sendMessage(str_replace(["&", "{label}"], ["§", "{$label}"], $config->get("usage_command")));
            return;
        }

        $i = $s->getInventory()->getItemInHand();

        if ($i->isNull()) {
            $s->sendMessage(str_replace(["&"], ["§"], $config->get("item_null")));
            return;
        }

        $name = implode(" ", $args);

        $i->setCustomName($name);
        $s->getInventory()->setItemInHand($i);
        $s->sendMessage(str_replace(["&", "{itemname}"], ["§", $name], $config->get("item_rename")));


    }
}
