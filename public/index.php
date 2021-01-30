<?php

require_once __DIR__.'/../vendor/autoload.php';

use Source\Core\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$dotenv = Dotenv\Dotenv::createImmutable( dirname(__DIR__ . '../') );
$dotenv->load();

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../source/Routes/routes.php';

$response = new Response();

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new Framework($matcher,$controllerResolver, $argumentResolver);

$response = $framework->handle($request);
$response->send();