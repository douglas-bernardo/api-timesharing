<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('root', new Route('/', [
    '_controller' => function(){
        return new Response('2021 - API Timesharing | Powered by Jackson Douglas!');
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

$routes->add('projetots', new Route('/projetots', [
    '_controller' => 'Source\Controller\ProjetoTSController::index'
]));

/**
 * Routes Ocorrencias
 */
$routes->add('ocorrencias', new Route('/ocorrencias', [
    '_controller' => 'Source\Controller\OcorrenciaController::index'
]));

$routes->add('ocorrencias_list_after_date', new Route('/ocorrencias/list-after-date', [
    '_controller' => 'Source\Controller\OcorrenciaController::listAfterDate'
]));

$routes->add('ocorrencias_list_after_number', new Route('/ocorrencias/list-after-number/{ocorrenciaId}', [
    '_controller' => 'Source\Controller\OcorrenciaController::listAfterNumber'
]));

$routes->add('ocorrencias_show', new Route('/ocorrencias/{ocorrenciaId}', [
    '_controller' => 'Source\Controller\OcorrenciaController::show'
]));

return $routes;