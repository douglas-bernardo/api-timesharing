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
            Transaction::open('api_renegociacao');

            $repository = new Repository('Source\Models\ProjetoTS', true);
            $criteria = new Criteria;
            $projetos = $repository->load($criteria);

            foreach ($projetos as $projeto) {
                $result[] = $projeto->toArray();
            }

            return new JsonResponse([
                'total' => count($result),
                'data' => $result
            ]);

            Transaction::close();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
