<?php

namespace Framework\Http\Router;

class ActionResolver
{
    public function resolve($handler): callable
    {
        return \is_string($handler) ? new  $handler() : $handler;
    }
}