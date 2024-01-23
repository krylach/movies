<?php

namespace Engine;

class Route
{
    public \stdClass $setting;

    public function __construct($setting = [])
    {
        $this->setting = (object)$setting;
    }

    public static function __callStatic($name, $arguments)
    {
        if (method_exists(self::class, $name)) {
            call_user_func_array([new static, $name], $arguments);
        }
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            call_user_func_array([$this, $name], $arguments);
        }
    }

    private function group(array $setting, callable $closure)
    {
        $this->setting = (object)$setting;

        $closure(new static($setting));
    }

    private function post($route, $controller, $name)
    {
        $this->callAdd($this->buildRoute($route), $controller, $name, __FUNCTION__);
    }

    private function get($route, $controller, $name)
    {
        $this->callAdd($this->buildRoute($route), $controller, $name, __FUNCTION__);
    }

    private function callAdd($route, $controller, $name, $method)
    {
        global $kernel;

        $kernel->setRoute(
            $name,
            $this->setting,
            new \Symfony\Component\Routing\Route(
                $route,
                ['_controller' => $controller],
                [],
                [],
                null,
                [],
                $method
            )
        );
    }

    public function buildRoute($route)
    {
        if (isset($this->setting->prefix)) {
            if ($route === '/') {
                $route = '';
            }

            $route = "{$this->setting->prefix}$route";
        }

        return $route;
    }
}
