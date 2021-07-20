<?php


namespace App\Modules\UserSystem\Repositories;


interface IUserSystemRepository
{
    public function find(string $query): array;
}