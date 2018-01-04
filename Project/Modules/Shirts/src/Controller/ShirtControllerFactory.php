<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 05:25
 */

namespace Shirts\Controller;


use App\Core\Container\FactoryInterface;

class ShirtControllerFactory implements FactoryInterface
{
    public function make($container, $requestedName)
    {
        $controller = new ShirtController();

        return $controller;
    }
}