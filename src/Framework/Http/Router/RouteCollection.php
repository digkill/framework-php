<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Route\RegexpRoute;
use Framework\Http\Router\Route\RouterInterface;

class RouteCollection
{

    private $routes = [];

    public function addRoute(RouterInterface $route): void
    {
        $this->routes[] = $route;
    }

    public function any($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, [], $tokens);
    }

    public function get($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens);
    }

    public function post($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens);
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}