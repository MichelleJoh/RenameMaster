<?php

namespace RenameMaster;

use pocketmine\plugin\PluginBase;
use RenameMaster\command\RenameCommand;

class Loader extends PluginBase {

    protected static $intance;

    protected function onLoad(): void
    {
        self::$intance = $this;
    }

    protected function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register("MasterRename", new RenameCommand());
        $this->saveResource("config.yml");
    }

    public static function getIntance()
    {
        return self::$intance;
    }

}
