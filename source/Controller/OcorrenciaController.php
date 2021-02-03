<?php

namespace Source\Controller;

use Source\Database\Criteria;
use Source\Database\Filter;
use Source\Database\Repository;
use Source\Database\Transaction;
use Source\Log\LoggerTXT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OcorrenciaController
{
    public function index()
    {
        try {
            Transaction::open($_ENV['APPLICATION']);
            $result = array();

            $repository = new Repository('Source\Models\Ocorrencia', true);
            $criteria = new Criteria;
            $ocorrencias = $repository->load($criteria);

            if ($ocorrencias) {
                foreach ($ocorrencias as $ocorrencia) {
                    $result[] = $ocorrencia->toArray();
                }
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

    public function show($ocorrenciaId)
    {
        try {
            Transaction::open($_ENV['APPLICATION']);

            $repository = new Repository('Source\Models\Ocorrencia', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('numero_ocorrencia', '=', $ocorrenciaId));
            $result = $repository->load($criteria);

            $ocorrencia = $result ? $result[0]->toArray() : null;

            return new JsonResponse([
                'total' => count($result),
                'data' => $ocorrencia
            ]);

            Transaction::close();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function listAfterNumber($ocorrenciaId)
    {
        try {
            Transaction::open($_ENV['APPLICATION']);
            Transaction::setLogger(new LoggerTXT(__DIR__ . '/../../tmp/listAfter.log'));
            $result = array();

            $repository = new Repository('Source\Models\Ocorrencia', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('numero_ocorrencia', '>', $ocorrenciaId));
            $ocorrencias = $repository->load($criteria);

            if ($ocorrencias) {
                foreach ($ocorrencias as $ocorrencia) {
                    $result[] = $ocorrencia->toArray();
                }
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

    public function listAfterDate(Request $request)
    {
        try {
            $data = $request->get('date');

            if (!$data) {
                return new JsonResponse(['error', 'parameter date is riquired']);
            }

            Transaction::open($_ENV['APPLICATION']);
            Transaction::setLogger(new LoggerTXT(__DIR__ . '/../../tmp/listAfter.log'));
            $result = array();

            $repository = new Repository('Source\Models\Ocorrencia', true);
            $criteria = new Criteria;
            $criteria->add(new Filter('dtocorrencia', '>=', $data));
            $ocorrencias = $repository->load($criteria);

            if ($ocorrencias) {
                foreach ($ocorrencias as $ocorrencia) {
                    $result[] = $ocorrencia->toArray();
                }
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
