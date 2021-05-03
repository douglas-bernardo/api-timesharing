<?php


namespace App\Modules\BillingDocuments\Services;


use App\Modules\BillingDocuments\Repositories\IBillingDocumentsRepository;

class ListBillingDocumentsService
{
    private IBillingDocumentsRepository $billingDocumentsRepository;
    public function __construct(IBillingDocumentsRepository $billingDocumentsRepository)
    {
        $this->billingDocumentsRepository = $billingDocumentsRepository;
    }

    public function execute(string $saleTsId): array
    {
        return $this->billingDocumentsRepository->findAll($saleTsId);
    }
}