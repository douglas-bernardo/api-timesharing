<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Repository;
use Source\Database\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;

class DocumentosCobrancaController
{
    public function show($idvendats)
    {
        try {
            if (!isset($idvendats)) {
                return new JsonResponse(['error' => 'parameter idvendats not informed or invalid']);
            }

            Transaction::open('api_renegociacao');

            $repository = new Repository('Source\Models\DocumentosCobranca', true);
            $repository->addViewParameter('PARAM_FILTER', "V.IDVENDATS = {$idvendats}");
            $criteria = new Criteria;
            $docs = $repository->load($criteria);

            foreach ($docs as $doc) {
                $result[] = $doc->toArray();
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