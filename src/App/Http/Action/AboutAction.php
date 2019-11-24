<?php

namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class AboutAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new JsonResponse('I am a simple site');
    }
}