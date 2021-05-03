<?php


namespace App\Modules\Contract\Infra\Database\Repository;


use App\Modules\Contract\Infra\Database\Entity\Contract;
use App\Modules\Contract\Repositories\IContractRepository;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Filter;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;

/**
 * Class ContractRepository
 * @package App\Modules\Contract\Infra\Database\Repository
 */
class ContractRepository implements IContractRepository
{

    /**
     * @param string $saleXContractId
     * @return \App\Modules\Contract\Infra\Database\Entity\Contract|null
     * @throws \Exception
     */
    public function findBySaleXContractId(string $saleXContractId): ?Contract
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());

        $criteria = new Criteria();
        $criteria->add(new Filter('idvendaxcontrato', '=', $saleXContractId));

        $repository = new Repository(Contract::class, true);
        $result = $repository->load($criteria);

        $result = $result ? $result[0] : null;

        Transaction::close();

        return $result;
    }
}