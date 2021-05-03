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

/**
 * Routes Contract
 */
$routes->add('contract', new Route('/contract/{saleXContractId}', [
    '_controller' => 'App\Modules\Contract\Infra\Http\Controllers\ShowContractController::show'
]));


/**
 * Routes Billing Docs
 */
$routes->add('list-billing-documents', new Route('/list-billing-documents/{saleTsId}', [
    '_controller' => 'App\Modules\BillingDocuments\Infra\Http\Controllers\BillingDocumentsController::index'
]));


/**
 * Routes Product
 */
$routes->add('product-ts', new Route('/product', [
    '_controller' => 'App\Modules\ProductTS\Infra\Http\Controllers\ProductTSController::index'
]));


/**
 * Routes OccurrenceController
 */
$routes->add('occurrences', new Route('/occurrences', [
    '_controller' => 'App\Modules\Occurrence\Infra\Http\Controllers\OccurrenceController::index'
]));

$routes->add(
    'list-recent-occurrences-by-date',
    new Route('/occurrences/list-recent-occurrences-by-date',
    ['_controller' => 'App\Modules\Occurrence\Infra\Http\Controllers\RecentOccurrencesByDateController::index']
    )
);

$routes->add(
    'list-recent-occurrences-by-number',
    new Route('/occurrences/list-recent-occurrences-by-number/{occurrenceNumber}',
    ['_controller' => 'App\Modules\Occurrence\Infra\Http\Controllers\RecentOccurrencesByNumberController::index']
    )
);

$routes->add('occurrences-show', new Route('/occurrences/{occurrenceNumber}', [
    '_controller' => 'App\Modules\Occurrence\Infra\Http\Controllers\ShowOccurrenceController::show'
]));


/**
 * Routes CustomerServiceController
 */
$routes->add(
    'after-sales-customer-services',
    new Route('/after-sales-customer-services/{customerTSId}', [
    '_controller' => 'App\Modules\AfterSalesCustomerService\Infra\Http\Controllers\AfterSalesCustomerServiceController::index'
]));

return $routes;