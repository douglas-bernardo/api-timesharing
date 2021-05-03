<?php


namespace App\Modules\Contract\Infra\Http\Controllers;


use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShowContractController
 * @package App\Modules\Contract\Infra\Http\Controllers
 */
class ShowContractController
{
    /**
     * @param string $saleXContractId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function show(string $saleXContractId): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $showContractService = $containerBuilder->get('showContract.service');
        $contract = $showContractService->execute($saleXContractId);

        return new JsonResponse([
            'status' => 'success',
            'data' => $contract->toArray(),
        ], 200);
    }
}