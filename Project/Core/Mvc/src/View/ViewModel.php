<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 29.12.17
 * Time: 21:39
 */

namespace App\Core\Mvc\View;


use App\Core\Router\Response;

class ViewModel
{
    private $statusCode = 200;

    private $file;

    private $variable = [];

    private $layout = APPLICATION_MODULE_ROOT . "/view/layout/layout.phtml";

    private $plugins;

    public function __construct($filepath)
    {
        if (!file_exists($filepath)) {
            return;
        }

        $this->file = $filepath;
    }

    /**
     * @return array
     */
    public function setVariable($key, $value)
    {
        $this->variable[$key] = $value;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function render()
    {
        header('Content-Type: text/html');
        Response::http_response_code($this->statusCode);
        extract($this->variable);

        include $this->layout;
    }

    private function getContent()
    {
        include $this->file;
    }

    /**
     * @return mixed
     */
    public function getPlugin($name)
    {
        return $this->plugins[$name];
    }

    /**
     * @param mixed $plugins
     */
    public function setPlugins($name, $plugin)
    {
        $this->plugins[$name] = $plugin;
    }
}