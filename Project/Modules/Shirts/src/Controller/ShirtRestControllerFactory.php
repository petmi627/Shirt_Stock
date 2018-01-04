<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 22.12.17
 * Time: 20:18
 */

namespace Shirts\Controller;


use App\Core\Container\FactoryInterface;
use Shirts\Repository\ShirtRepository;

class ShirtRestControllerFactory implements FactoryInterface
{
    public function make($container, $requestedName)
    {
        $controller = new ShirtRestController();
        $controller->setShirtRepository(
            $container->get(ShirtRepository::class)
        );

        return $controller;
    }
}