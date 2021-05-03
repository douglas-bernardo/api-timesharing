<?php

namespace App\Modules\AfterSalesCustomerService\Infra\Database\Entity;


use App\Shared\Infra\Database\Record;

/**
 * Class AfterSalesCustomerServiceController
 * @package App\Models
 */
class AfterSalesCustomerService extends Record
{
    /**
     * SQL view that get all customer service registered in timesharing
     */
    const TABLENAME = 'cm_atendimentosts';
}