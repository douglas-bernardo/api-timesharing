<?php


namespace App\Modules\Occurrence\Infra\Http\Controllers;


use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShowOccurrenceController
 * @package App\Modules\Occurrence\Infra\Http\Controllers
 */
class ShowOccurrenceController
{
    /**
     * @param string $occurrenceNumber
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function show(string $occurrenceNumber): JsonResponse
    {
        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $showOccurrenceService = $containerBuilder->get('showOccurrence.service');
        $occurrence = $showOccurrenceService->execute($occurrenceNumber);
        return new JsonResponse([
            'status' => 'success',
            'data' => $occurrence->toArray(),
        ], 200);
    }
}