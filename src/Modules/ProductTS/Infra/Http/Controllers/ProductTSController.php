<?php


namespace App\Modules\ProductTS\Infra\Http\Controllers;

use Exception;
use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductTSController
 * @package App\Modules\ProductTS\Infra\Http\Controllers
 */
class ProductTSController
{

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $listProductTsService = $containerBuilder->get('listProductTsService.service');
        $occurrences = $listProductTsService->execute();
        return new JsonResponse([
            'status' => 'success',
            'data' => $occurrences,
        ], 200, ['x-total-count' => count($occurrences)]);
    }
}