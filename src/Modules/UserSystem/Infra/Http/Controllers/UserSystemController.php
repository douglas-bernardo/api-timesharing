<?php


namespace App\Modules\UserSystem\Infra\Http\Controllers;


use App\Modules\UserSystem\Services\FindUserSystemService;
use App\Shared\Facades\ContainerDependenceInjection\ContainerDependenceInjection;
use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserSystemController
{
    /**
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->get('query');
        if (!$query) {
            return new JsonResponse([
                'status' => 'fail',
                'data' => 'parameter query is required'
            ], 400);
        }

        $containerBuilder = ContainerDependenceInjection::getInstance();
        $loader = new YamlFileLoader($containerBuilder, new FileLocator());
        $loader->load(CONF_CONTAINER_CONFIG);

        /** @var FindUserSystemService $findUserSystemService */
        $findUserSystemService = $containerBuilder->get('findUserSystem.service');
        $users = $findUserSystemService->execute($query);

        return new JsonResponse([
            'status' => 'success',
            'data' => $users,
        ], 200, ['x-total-count' => count($users)]);
    }
}