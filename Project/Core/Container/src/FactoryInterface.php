<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 20.12.17
 * Time: 18:47
 */

namespace App\Core\Container;


interface FactoryInterface
{
    public function make($container, $requestedName);
}