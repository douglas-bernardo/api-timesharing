<?php


namespace App\Modules\ProductTS\Repositories;


interface IProductTSRepository
{
    public function findAll(): array;
}