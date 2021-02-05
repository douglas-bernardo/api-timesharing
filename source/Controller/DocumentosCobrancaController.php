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
                return new JsonResponse([
                    'status' => 'fail',
                    'data' => [
                        'idvendats' => 'parameter idvendats not informed or invalid'
                    ]
                ]);
            }

            Transaction::open($_ENV['APPLICATION']);
            $result = array();

            $repository = new Repository('Source\Models\DocumentosCobranca', true);
            $repository->addViewParameter('PARAM_FILTER', "V.IDVENDATS = {$idvendats}");
            $criteria = new Criteria;
            $docs = $repository->load($criteria);

            if ($docs) {
                foreach ($docs as $doc) {
                    $result[] = $doc->toArray();
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
