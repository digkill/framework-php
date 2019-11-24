<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Exception\RequestNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

use Psr\Http\Message\ServerRequestInterface;

class SimpleRouter implements Router
{
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        foreach ($this->routes->getRoutes() as $route) {
            if (null !== $url = $route->$this->generate($name, array_filter($params))) {
                return $url;
            }
        }

        throw new RequestNotFoundException($name, $params);
    }

}