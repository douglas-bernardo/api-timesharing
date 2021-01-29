<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Repository;
use Source\Database\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class MotivoController
{
    public function index()
    {
        try {
            Transaction::open('api_renegociacao');

            $repository = new Repository('Source\Models\Motivo', true);
            $criteria = new Criteria;
            $motivos = $repository->load($criteria);

            foreach ($motivos as $motivo) {
                $result[] = $motivo->toArray();
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
