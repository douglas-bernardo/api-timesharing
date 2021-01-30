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
                return new JsonResponse(['error' => 'parameter idvendaxcontrato not informed or invalid']);
            }

            Transaction::open($_ENV['APPLICATION']);

            $repository = new Repository('Source\Models\Contrato', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('idvendaxcontrato', '=', $idvendaxcontrato));
            $contratos = $repository->load($criteria);

            foreach ($contratos as $contrato) {
                $result[] = $contrato->toArray();
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
