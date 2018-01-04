<?php

namespace Application;

class Module
{
    public function init()
    {
        if (!defined("APPLICATION_MODULE_ROOT")) {
            define("APPLICATION_MODULE_ROOT", realpath(__DIR__) . "/..");
        }
    }

    public function getConfig()
    {
        $this->init();
        return include APPLICATION_MODULE_ROOT . "/config/module.config.php";
    }
}
