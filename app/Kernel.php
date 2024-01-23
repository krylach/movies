<?php

namespace App;

use Engine\AutoInstancedDependency;
use Engine\Collection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    const CONTROLLER_ELEMENT = '_controller';
    const ROUTE_CONTROLLER   = '_route';
    const DEFAULT_HTTPS_PORT = 443;

    private RouteCollection $routes;
    private RequestContext $context;
    private Request $request;
    private array $settings;

    public function __construct()
    {
        $this->routes = new RouteCollection();
        $this->request = Request::createFromGlobals();
    }

    public function build()
    {
        $this->requireRoutes();

        return $this;
    }

    public function handler()
    {
        $uri = str_replace($_SERVER['QUERY_STRING'] ?? '', '',
            $this->request->getRequestUri()
        );

        $uri = str_replace([$this->request->getQueryString(), '?'], '', 
            $uri
        );

        $requestContext = new RequestContext(
            $this->request->getBaseUrl(),
            $this->request->getMethod(),
            $this->request->getHost(),
            $this->request->getScheme(),
            $this->request->getPort(),
            self::DEFAULT_HTTPS_PORT,
            $uri,
            $this->request->getQueryString() ?? ''
        );

        try {
            $matcher = new UrlMatcher($this->routes, $requestContext);
            $matched = $matcher->match($uri);
        } catch (\Exception $exception) {
            header("HTTP/1.0 404 Not Found");
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            return ;
        }

        if (isset($this->settings[$matched['_route']])) {
            if (isset($this->settings[$matched['_route']]->middlewares)) {
                $middlewares = $this->settings[$matched['_route']]->middlewares;

                foreach ($middlewares as $middleware) {
                    (new $middleware)->handle();
                }
            }
        }

        list($controller, $method) = $matched['_controller'];

        $collectedDependencies 
            = $this->collectDependencies($controller, $method, $matched);

        foreach ($matched as $key => $value) {
            if ($key === self::CONTROLLER_ELEMENT || $key === self::ROUTE_CONTROLLER) {
                continue;
            }

            $collectedDependencies->add($value);
        }

        $dependencies = $collectedDependencies->toArray();

        return call_user_func_array([new $controller, $method], $dependencies);
    }

    public function setRoute($name, \stdClass $setting, Route $route)
    {
        $this->settings[$name] = $setting;
        $this->routes->add($name, $route);
    }

    private function collectDependencies($controller, $method, $data): Collection
    {
        $reflection = new \ReflectionClass($controller);
        $dependency = new AutoInstancedDependency(
            $reflection->getMethod($method),
            $data
        );
        
        return $dependency->execute();
    }

    private function requireRoutes()
    {
        $filesPath = (array)config('routes.files_path');
        $finder = new Finder();

        foreach ($finder->files()->in($filesPath) as $file) {
            require_once($file);
        }
    }
}
