<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 23.11.17
 * Time: 14:46
 */

namespace App\Core\Container;


interface ContainerInterface
{
    public function make($name, $factory);
}
