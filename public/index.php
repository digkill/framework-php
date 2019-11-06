<?php

use Framework\Http\RequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = (new Request())
    ->withQueryParams($_GET)
    ->withParsedBody($_POST);

$request = RequestFactory::fromGlobals();

$name = $request->getQueryParams()['name'] ?? 'Guest';
header('X-Developer: Edifanoff');
echo 'Hello, ' . $name . '!';