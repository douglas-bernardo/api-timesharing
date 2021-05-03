<?php


namespace App\Modules\BillingDocuments\Infra\Http\Controllers;


use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BillingDocumentsController
 * @package App\Modules\BillingDocuments\Infra\Http\Controllers
 */
class BillingDocumentsController
{
    /**
     * @param string $saleTsId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function index(string $saleTsId): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $listBillingDocumentsService = $containerBuilder->get('listBillingDocumentsService.service');
        $docs = $listBillingDocumentsService->execute($saleTsId);
        return new JsonResponse([
            'status' => 'success',
            'data' => $docs,
        ], 200, ['x-total-count' => count($docs)]);
    }
}