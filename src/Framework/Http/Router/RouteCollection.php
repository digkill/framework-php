<?php

namespace Framework\Http\Router;

class RouteCollection
{

    private $routes = [];

    public function any($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, [], $tokens);
    }

    public function get($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, ['GET'], $tokens);
    }

    public function post($name, $pattern, $handler, array $tokens = []): void
    {
        $this->routes[] = new Route($name, $pattern, $handler, ['POST'], $tokens);
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}