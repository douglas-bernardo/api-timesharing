<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Expose-Headers: x-total-count');
if($_SERVER["REQUEST_METHOD"] == "OPTIONS") exit();

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$dotenv = Dotenv\Dotenv::createImmutable( dirname(__DIR__ . '../') );
$dotenv->load();

$routes = include __DIR__ . '/../src/Shared/Infra/Http/Routes/routes.php';
$container = include __DIR__ . '/../src/Shared/Container/container.php';
$container->setParameter('routes', $routes);

$request = Request::createFromGlobals();

$response = $container->get('framework')->handle($request);

$response->send();