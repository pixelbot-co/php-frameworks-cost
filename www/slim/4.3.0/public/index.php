<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/slim/4.3.0/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello, World! (slim/4.3.0)");
    return $response;
});

$app->run();

