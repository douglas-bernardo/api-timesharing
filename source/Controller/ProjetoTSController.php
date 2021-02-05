<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Repository;
use Source\Database\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjetoTSController
{
    public function index()
    {
        try {
            Transaction::open($_ENV['APPLICATION']);

            $result = array();
            $repository = new Repository('Source\Models\ProjetoTS', true);
            $criteria = new Criteria;
            $projetos = $repository->load($criteria);

            if ($projetos) {
                foreach ($projetos as $projeto) {
                    $result[] = $projeto->toArray();
                }
            }

            return new JsonResponse([
                'status' => 'success',
                'total' => count($result),
                'data' => $result
            ]);

            Transaction::close();
        } catch (\PDOException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
