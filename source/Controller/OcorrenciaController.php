<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Repository;
use Source\Database\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class OcorrenciaController
{
    public function index()
    {
        try {
            Transaction::open($_ENV['APPLICATION']);

            $repository = new Repository('Source\Models\Ocorrencia', true);
            $criteria = new Criteria;
            $ocorrencias = $repository->load($criteria);

            foreach ($ocorrencias as $ocorrencia) {
                $result[] = $ocorrencia->toArray();
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
