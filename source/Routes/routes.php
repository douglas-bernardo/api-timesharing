<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('root', new Route('/', [
    '_controller' => function(){
        return new Response('Hello World!');
    }
]));

$routes->add('motivos', new Route('/motivos', [
    '_controller' => 'Source\Controller\MotivoController::index'
]));

$routes->add('contrato', new Route('/contrato/{idvendaxcontrato}', [
    '_controller' => 'Source\Controller\ContratoController::show'
]));

$routes->add('documentos_cobranca', new Route('/cobranca/{idvendats}/docs', [
    '_controller' => 'Source\Controller\DocumentosCobrancaController::show'
]));

$routes->add('ocorrencias', new Route('/ocorrencias', [
    '_controller' => 'Source\Controller\OcorrenciaController::index'
]));

$routes->add('projetots', new Route('/projetots', [
    '_controller' => 'Source\Controller\ProjetoTSController::index'
]));

return $routes;