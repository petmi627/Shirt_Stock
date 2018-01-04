<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 31.12.17
 * Time: 00:47
 */

namespace Shirts\Repository;

use App\Core\Container\FactoryInterface;

class ShirtRepositoryFactory implements FactoryInterface
{
    public function make($container, $requestedName)
    {
        $repository = new ShirtRepository($container->get("Database")->getPDO());

        return $repository;
    }
}