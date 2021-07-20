<?php


namespace App\Modules\UserSystem\Services;


use App\Modules\UserSystem\Repositories\IUserSystemRepository;

class FindUserSystemService
{
    private IUserSystemRepository $userSystemRepository;

    public function __construct(IUserSystemRepository $userSystemRepository)
    {
        $this->userSystemRepository = $userSystemRepository;
    }

    public function execute(string $query): array
    {
        return $this->userSystemRepository->find($query);
    }
}