<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 23.11.17
 * Time: 14:07
 */

namespace App\Core\Container;


class Container implements ContainerInterface
{
    private $instances = [];

    /**
     * @return array
     */
    public function getInstances(): array
    {
        return $this->instances;
    }

    public function get($name)
    {
        return $this->instances[$name];
    }

    public function has($name)
    {
        if (isset($this->instances[$name])) {
            return true;
        }

        return false;
    }

    public function make($name, $factory)
    {
        if (!empty($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (isset($factory)) {
            $this->instances[$name] = $factory;
        } else {
            throw new \Exception("no Factory given");
        }

        return $this->instances[$name];
    }
}