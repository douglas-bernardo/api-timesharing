<?php


namespace App\Modules\UserSystem\Infra\Database\Repository;


use App\Modules\UserSystem\Infra\Database\Entity\UserSystem;
use App\Modules\UserSystem\Repositories\IUserSystemRepository;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;
use Exception;

class UserSystemRepository implements IUserSystemRepository
{

    /**
     * @throws Exception
     */
    public function find(string $query): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());

        $query = mb_strtoupper(trim($query));
        $repository = new Repository(UserSystem::class, true);
        $repository->addViewParameter('QUERY_PARAM', "US.NOMEUSUARIO LIKE '{$query}%'");

        $users = $repository->load(new Criteria());

        $result = array();
        if ($users) {
            foreach ($users as $user) {
                $result[] = $user->toArray();
            }
        }

        Transaction::close();
        return $result;
    }
}