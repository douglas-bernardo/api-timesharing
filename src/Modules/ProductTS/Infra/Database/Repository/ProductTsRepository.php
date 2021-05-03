<?php


namespace App\Modules\ProductTS\Infra\Database\Repository;


use App\Modules\ProductTS\Infra\Database\Entity\ProductTS;
use App\Modules\ProductTS\Repositories\IProductTSRepository;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;

/**
 * Class ProductTsRepository
 * @package App\Modules\ProductTS\Infra\Database\Repositories
 */
class ProductTsRepository implements IProductTSRepository
{

    /**
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());

        $repository = new Repository(ProductTS::class, true);
        $products = $repository->load(new Criteria());

        $result = [];
        /** @var ProductTS $product */
        if ($products) {
            foreach ($products as $product) {
                $result[] = $product->toArray();
            }
        }
        Transaction::close();
        return $result;
    }
}