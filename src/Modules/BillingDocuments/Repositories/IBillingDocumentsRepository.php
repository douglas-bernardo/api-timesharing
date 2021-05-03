<?php


namespace App\Modules\BillingDocuments\Repositories;


interface IBillingDocumentsRepository
{
    public function findAll(string $saleTsId): array;
}