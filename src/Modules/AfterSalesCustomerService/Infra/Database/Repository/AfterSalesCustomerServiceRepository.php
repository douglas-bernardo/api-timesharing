<?php


namespace App\Modules\AfterSalesCustomerService\Infra\Database\Repository;


use App\Modules\AfterSalesCustomerService\Infra\Database\Entity\AfterSalesCustomerService;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Filter;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;

/**
 * Class AfterSalesCustomerServiceRepository
 * @package App\Modules\AfterSalesCustomerService\Infra\Database\Repositories
 */
class AfterSalesCustomerServiceRepository implements \App\Modules\AfterSalesCustomerService\Repositories\IAfterSalesCustomerServiceRepository
{

    /**
     * @param string $customerTSId
     * @return array
     * @throws \Exception
     */
    public function findAll(string $customerTSId): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());

        $criteria = new Criteria();
        $criteria->setProperty('order', 'dataobservacao DESC');
        $criteria->add(new Filter('idcliente', '=', $customerTSId));

        $repository = new Repository(AfterSalesCustomerService::class, true);
        $entries = $repository->load($criteria);

        $result = array();

        /** @var AfterSalesCustomerService $entry */
        if ($entries) {
            foreach ($entries as $entry) {
                $result[] = $entry->toArray();
            }
        }

        Transaction::close();
        return $result;
    }
}