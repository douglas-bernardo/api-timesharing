<?php


namespace App\Modules\Occurrence\Infra\Http\Controllers;

use Exception;
use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

class OccurrenceController
{
    /**
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $listOccurrenceService = $containerBuilder->get('occurrence.service');
        $occurrences = $listOccurrenceService->execute();
        return new JsonResponse([
            'status' => 'success',
            'data' => $occurrences,
        ], 200, ['x-total-count' => count($occurrences)]);
    }
}