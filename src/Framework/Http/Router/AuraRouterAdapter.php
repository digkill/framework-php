<?php

namespace Framework\Http\Router;

use Aura\Router\Route;
use Aura\Router\Exception\RouteNotFound;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Exception\RequestNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements Router
{

    /**
     * @var RouterContainer
     */
    private $aura;

    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Result
     * @throws RequestNotMatchedException
     */
    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();
        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RequestNotMatchedException($request);
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     * @throws RequestNotFoundException
     */
    public function generate($name, array $params = []): string
    {
        $generator = $this->aura->getGenerator();

        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new RequestNotFoundException($name, $params, $e);
         }
    }
}