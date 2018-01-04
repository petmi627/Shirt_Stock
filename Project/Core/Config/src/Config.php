<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 23.11.17
 * Time: 14:46
 */

namespace App\Core\Config;


class Config
{
    public $config = [];

    public function __construct(array $config = [])
    {
          $this->config = $config;
    }

    public function merge($config)
    {
        $this->config = array_merge_recursive($this->config, $config);
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
