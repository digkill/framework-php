<?php

namespace Framework\Http\Router\Route;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return Result
     * @throws RequestNotMatchedException
     */
    public function match(ServerRequestInterface $request): ?Result;

    /**
     * @param $name
     * @param array $params
     * @return string
     * @throws RouteNotFoundException
     */
    public function generate($name, array $params): ?string;

    /**
     * @param RouteData $data
     */
    public function addRoute(RouteData $data): void;
}