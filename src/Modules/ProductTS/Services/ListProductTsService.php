<?php


namespace App\Modules\ProductTS\Services;


use App\Modules\ProductTS\Repositories\IProductTSRepository;

class ListProductTsService
{
    private IProductTSRepository $productTSRepository;
    public function __construct(IProductTSRepository $productTSRepository)
    {
        $this->productTSRepository = $productTSRepository;
    }

    public function execute(): array
    {
        return $this->productTSRepository->findAll();
    }
}