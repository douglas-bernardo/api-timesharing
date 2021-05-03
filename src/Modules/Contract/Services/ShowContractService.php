<?php


namespace App\Modules\Contract\Services;


use App\Modules\Contract\Infra\Database\Entity\Contract;
use App\Modules\Contract\Repositories\IContractRepository;

class ShowContractService
{
    private IContractRepository $contractRepository;

    public function __construct(IContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function execute(string $saleXContractId): ?Contract
    {
        return $this->contractRepository->findBySaleXContractId($saleXContractId);
    }
}