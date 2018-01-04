<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 20:16
 */

namespace Shirts;


class Module
{
    public function init()
    {
        if (!defined("SHIRT_MODULE_ROOT")) {
            define("SHIRT_MODULE_ROOT", realpath(__DIR__) . "/..");
        }
    }

    public function getConfig()
    {
        $this->init();
        return include SHIRT_MODULE_ROOT . "/config/module.config.php";
    }
}