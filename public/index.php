<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Framework\Http\Router\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\Response\JsonResponse;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Init
$aura = new Aura\Router\RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', App\Http\Action\HelloAction::class);
$routes->get('about', '/about', App\Http\Action\AboutAction::class);
$routes->get('blog', '/blog', App\Http\Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', App\Http\Action\Blog\ShowAction::class, ['id' => '\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

### Running
$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $resolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

### Postprocessing
$response = $response->withHeader('X-Developer', 'Edifanoff');

### Send
$emitter = new SapiEmitter();
$emitter->emit($response);