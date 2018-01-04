<?php
/**
 * Created by PhpStorm.
 * User: petmi627
 * Date: 20.12.17
 * Time: 18:49
 */

namespace App\Core\Router;


class Router
{
    private $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getBaseUrl()
    {
        return sprintf("%s://%s%s", $_SERVER["REQUEST_SCHEME"], $_SERVER["HTTP_HOST"], $_SERVER["PHP_SELF"]);
    }

    public function getRoute()
    {
        $current_route = $this->getCurrentRoute();
        $routes_config = $this->config["router"]["routes"];

        return $this->loopConfig($routes_config, $current_route);
    }

    public function loopConfig($config, $current_route, $prefix = '')
    {
        foreach ($config as $route => $config) {
            if ($prefix . $config["options"]["route"] == $current_route) {
                return $config;
                break;
            }

            if (isset($config["child_routes"])) {
                return $this->loopConfig($config["child_routes"], $current_route, $config["options"]["route"]);
            }

            $error = 404;
            continue;
        }

        return $error;
    }

    private function getCurrentRoute()
    {
        if (isset($_GET["action"])) {
            return $_GET["action"];
        }

        if (isset($_POST["action"])) {
            return $_POST["action"];
        }

        return 'home';
    }

    public function getMethod()
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);

        if (!in_array($method, ["get", "post", "put", "delete"])) {
            return 405;
        }

        switch ($method) {
            case "get":
                return "get";
            case "post":
                return "create";
            case "put":
                return "update";
            case "delete":
                return "delete";
        }
    }
}