<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Filter;
use Source\Database\Repository;
use Source\Database\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContratoController
{
    public function show($idvendaxcontrato)
    {
        try {
            
            if (!isset($idvendaxcontrato)) {
                return new JsonResponse([
                    'status' => 'fail',
                    'data' => [
                        'idvendaxcontrato' => 'parameter idvendaxcontrato not informed or invalid'
                    ]
                ]);
            }

            Transaction::open($_ENV['APPLICATION']);

            $repository = new Repository('Source\Models\Contrato', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('idvendaxcontrato', '=', $idvendaxcontrato));
            $result = $repository->load($criteria);

            $result = $result ? $result[0]->toArray() : [];

            return new JsonResponse([
                'status' => 'success',
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
