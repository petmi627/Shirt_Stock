<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 20.12.17
 * Time: 18:46
 */

namespace Application\Controller;


use App\Core\Container\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function make($container, $requestedName)
    {
        $controller = new IndexController();

        return $controller;
    }
}