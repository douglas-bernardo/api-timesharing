<?php


namespace App\Modules\AfterSalesCustomerService\Services;


use App\Modules\AfterSalesCustomerService\Repositories\IAfterSalesCustomerServiceRepository;

class ListAfterSalesCustomerService
{
    private IAfterSalesCustomerServiceRepository $afterSalesCustomerServiceRepository;

    public function __construct(IAfterSalesCustomerServiceRepository $afterSalesCustomerServiceRepository)
    {
        $this->afterSalesCustomerServiceRepository = $afterSalesCustomerServiceRepository;
    }

    public function execute(string $customerTsId): array
    {
        return $this->afterSalesCustomerServiceRepository->findAll($customerTsId);
    }
}