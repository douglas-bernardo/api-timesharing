<?php


namespace App\Modules\AfterSalesCustomerService\Infra\Http\Controllers;


use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AfterSalesCustomerServiceController
 * @package App\Modules\AfterSalesCustomerService\Infra\Http\Controllers
 */
class AfterSalesCustomerServiceController
{
    /**
     * @param string $customerTSId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function index(string $customerTSId): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $listAfterSalesCustomerService = $containerBuilder->get('listAfterSalesCustomerService.service');
        $entries = $listAfterSalesCustomerService->execute($customerTSId);
        return new JsonResponse([
            'status' => 'success',
            'data' => $entries,
        ], 200, ['x-total-count' => count($entries)]);
    }
}