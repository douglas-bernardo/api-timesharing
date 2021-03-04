<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Filter;
use Source\Database\Repository;
use Source\Database\Transaction;
use Source\Log\LoggerTXT;
use Symfony\Component\HttpFoundation\JsonResponse;

class AtendimentoController
{
    public function index()
    {
        try {
            Transaction::open($_ENV['APPLICATION']);
            $result = array();

            $repository = new Repository('Source\Models\Atendimento', true);
            $criteria = new Criteria;

            $atendimentos = $repository->load($criteria);

            if ($atendimentos) {
                foreach ($atendimentos as $atendimento) {
                    $result[] = $atendimento->toArray();
                }
            }

            return new JsonResponse([
                'status' => 'success',
                'data' => $result
            ], 200, ['x-total-count' => count($result)]);

            Transaction::close();
        } catch (\PDOException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($idclientets)
    {
        try {

            if (!isset($idclientets)) {
                return new JsonResponse([
                    'status' => 'fail',
                    'data' => [
                        'idclientets' => 'parameter idclientets not informed or invalid'
                    ]
                ]);
            }

            Transaction::open($_ENV['APPLICATION']);
            Transaction::setLogger(new LoggerTXT(__DIR__ . '/../../tmp/atendimentos.log'));

            $repository = new Repository('Source\Models\Atendimento', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('idcliente', '=', $idclientets));
            
            $atendimentos = $repository->load($criteria);

            if ($atendimentos) {
                foreach ($atendimentos as $atendimento) {
                    $result[] = $atendimento->toArray();
                }
            }

            return new JsonResponse([
                'status' => 'success',
                'data' => $result
            ], 200, ['x-total-count' => count($result)]);

            Transaction::close();
        } catch (\PDOException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}