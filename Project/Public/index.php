<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 23.11.17
 * Time: 14:09
 */

use \App\Core\Application\Application;

define('PROJECT_ROOT', realpath(__DIR__) . "/..");

require PROJECT_ROOT . "/Config/autoload.php";

$config = array_merge_recursive(
    include PROJECT_ROOT . "/Config/core.php",
    include PROJECT_ROOT . "/Config/modules.php",
    include PROJECT_ROOT . "/Config/autoload/application.config.php"
);

$app = new Application($config);
$app->run();