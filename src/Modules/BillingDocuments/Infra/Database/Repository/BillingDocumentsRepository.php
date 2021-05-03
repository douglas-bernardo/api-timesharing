<?php


namespace App\Modules\BillingDocuments\Infra\Database\Repository;


use App\Modules\BillingDocuments\Infra\Database\Entity\BillingDocuments;
use App\Modules\BillingDocuments\Repositories\IBillingDocumentsRepository;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;

/**
 * Class BillingDocumentsRepository
 * @package App\Modules\BillingDocuments\Infra\Database\Repository
 */
class BillingDocumentsRepository implements IBillingDocumentsRepository
{

    /**
     * @param string $saleTsId
     * @return array
     * @throws \Exception
     */
    public function findAll(string $saleTsId): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());

        $repository = new Repository(BillingDocuments::class, true);
        $repository->addViewParameter('PARAM_FILTER', "V.IDVENDATS = $saleTsId");

        $docs = $repository->load(new Criteria());

        $result = [];
        /** @var BillingDocuments $doc */
        if ($docs) {
            foreach ($docs as $doc) {
                $result[] = $doc->toArray();
            }
        }

        Transaction::close();

        return $result;
    }
}