<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Init
$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse('Hello, ' . $name . '!');
});

$routes->get('about', '/about', function (ServerRequestInterface $request) {
    return new HtmlResponse('I am simple site');
});
$routes->get('blog', '/blog', function (ServerRequestInterface $request) {
    return new JsonResponse([
        ['id' => 2, 'title' => 'The Second Post'],
        ['id' => 1, 'title' => 'The First Post']
    ]);
});
$routes->get('blog_show', '/blog/{id}', function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');

    if ($id > 2) {
        return new JsonResponse(['error' => 'Undefined page'], 404);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
}, ['id' => '\d+']);

$router = new Router($routes);

### Running

$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $result->getHandler();
    $response = $action($request);

} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Edifanoff');

### Send

$emitter = new SapiEmitter();
$emitter->emit($response);