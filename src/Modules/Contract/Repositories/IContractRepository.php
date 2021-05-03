<?php


namespace App\Modules\Contract\Repositories;


use App\Modules\Contract\Infra\Database\Entity\Contract;

interface IContractRepository
{
    public function findBySaleXContractId(string $saleXContractId): ?Contract;
}