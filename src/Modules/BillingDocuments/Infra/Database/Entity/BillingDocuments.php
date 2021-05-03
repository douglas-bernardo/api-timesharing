<?php

namespace App\Modules\BillingDocuments\Infra\Database\Entity;



use App\Shared\Infra\Database\Record;

/**
 * Class BillingDocuments
 * @package App\Models
 */
class BillingDocuments extends Record
{
    /**
     * get all active billing docs customer
     */
    const TABLENAME = 'cm_documentos_cobranca';
}