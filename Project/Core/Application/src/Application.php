<?php

namespace App\Core\Application;

use App\Core\Container\Container;
use App\Core\Config\Config;
use App\Core\Database\Database;
use App\Core\I18n\Translator;
use App\Core\Mvc\View\ApplicationException;
use App\Core\Mvc\View\ViewModel;
use App\Core\Router\Router;

class Application
{
    /**
     * @var object Container
     */
    private $container;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Router
     */
    private $router;

    const MODULE = 'Module';

    public function __construct(array $config = [])
    {
        $this->container = new Container();
        $this->config = new Config($config);
        $this->container->make('Database', new Database($this->config->getConfig()));
    }

    private function loadModules()
    {

        $config = $this->config->getConfig();
        foreach($config["modules"]["namespaces"] as $module => $path) {
            $module = $module . "\\" . self::MODULE;
            $module = new $module();
            $this->config->merge($module->getConfig());
        }

        foreach ($this->config->getConfig()["service"]["factories"] as $service => $factories) {
            $factory = new $factories($this->container, $service);
            $this->container->make($service,
                $factory->make($this->container, $service)
            );
        }

        foreach ($this->config->getConfig()["controller"]["factories"] as $controller => $factories) {
            $factory = new $factories($this->container, $controller);
            $this->container->make($controller,
                $factory->make($this->container, $controller)
            );
        }

        $this->init();
    }

    private function init()
    {
        $this->router = new Router($this->config->getConfig());
        $this->container->make('Router', $this->router);
        $this->container->make('Config', $this->config->getConfig());
        $this->container->make('Translator', new Translator($this->config->getConfig()));
    }

    private function execute()
    {
        $route = $this->router->getRoute();
        if ($route == 404) {
            return ApplicationException::execute(404, "Requested page not found");
        }
        $method = $this->router->getMethod();
        if ($route == 405) {
            return ApplicationException::execute(405, "Requested method not allowed");
        }

        $controller = $route["options"]["defaults"]["controller"];
        if (!$this->container->has($controller)) {
            throw new \Exception('Controller not found in container');
        }

        $controller = $this->container->get($controller);

        if (isset($route["options"]["defaults"]["method"])) {
            $method = $route["options"]["defaults"]["method"] . "Action";
        } else if (isset($_GET["method"])) {
            $method = $_GET["method"] . "Action";
        }

        $result = $controller->$method();

        if ($result instanceof ViewModel) {
            $result->setPlugins('router', $this->router);
            $result->setPlugins('translator', $this->container->get('Translator'));
            $result->render();
        }
    }

    public function run()
    {
        $this->loadModules();
        $this->execute();
    }
}
