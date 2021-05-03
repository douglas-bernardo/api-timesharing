<?php


namespace App\Modules\AfterSalesCustomerService\Repositories;


interface IAfterSalesCustomerServiceRepository
{
    public function findAll(string $customerTSId): array;
}