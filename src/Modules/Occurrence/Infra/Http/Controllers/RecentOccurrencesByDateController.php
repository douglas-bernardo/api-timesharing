<?php


namespace App\Modules\Occurrence\Infra\Http\Controllers;

use Exception;
use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RecentOccurrencesByDateController
{
    /**
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $date = $request->get('date');

        if (!$date) {
            return new JsonResponse([
                'status' => 'fail',
                'data' => 'parameter date is required'
            ], 400);
        }

        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        $listRecentOccurrencesByDateService = $containerBuilder->get('listOccurrenceByDate.service');
        $occurrences = $listRecentOccurrencesByDateService->execute($date);
        return new JsonResponse([
            'status' => 'success',
            'data' => $occurrences,
        ], 200, ['x-total-count' => count($occurrences)]);
    }
}