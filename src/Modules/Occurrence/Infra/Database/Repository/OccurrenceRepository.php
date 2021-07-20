<?php


namespace App\Modules\Occurrence\Infra\Database\Repository;


use App\Modules\Occurrence\Infra\Database\Entity\Occurrence;
use App\Modules\Occurrence\Repositories\IOccurrenceRepository;
use App\Shared\Facades\Log\Log;
use App\Shared\Infra\Database\Criteria;
use App\Shared\Infra\Database\Filter;
use App\Shared\Infra\Database\Repository;
use App\Shared\Infra\Database\Transaction;
use Exception;

/**
 * Class OccurrenceRepository
 * @package App\Modules\Occurrence\Infra\Database\Repositories
 */
class OccurrenceRepository implements IOccurrenceRepository
{
    /**
     * @throws Exception
     */
    public function load(): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());
        $repository = new Repository(Occurrence::class, true);
        $occurrences = $repository->load(new Criteria());
        $result = array();
        if ($occurrences) {
            foreach ($occurrences as $occurrence) {
                $result[] = $occurrence->toArray();
            }
        }
        Transaction::close();
        return $result;
    }

    /**
     * @throws Exception
     */
    public function loadByNumber(string $OccurrenceNumber): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());
        $criteria = new Criteria();
        $criteria->add(new Filter('numero_ocorrencia', '>', $OccurrenceNumber));

        $repository = new Repository(Occurrence::class, true);
        $occurrences = $repository->load($criteria);

        $result = array();
        if ($occurrences) {
            foreach ($occurrences as $occurrence) {
                $result[] = $occurrence->toArray();
            }
        }

        Transaction::close();
        return $result;
    }

    /**
     * @throws Exception
     */
    public function loadByDate(string $date): array
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());
        $criteria = new Criteria();
        $criteria->add(new Filter('dtocorrencia', '>=', $date));

        $repository = new Repository(Occurrence::class, true);
        $occurrences = $repository->load($criteria);

        $result = array();
        if ($occurrences) {
            foreach ($occurrences as $occurrence) {
                $result[] = $occurrence->toArray();
            }
        }

        Transaction::close();
        return $result;
    }

    /**
     * @param string $occurrenceNumber
     * @return Occurrence|null
     * @throws Exception
     */
    public function findByNumber(string $occurrenceNumber): ?Occurrence
    {
        Transaction::open($_ENV['APPLICATION']);
        Transaction::setLogger(Log::getInstance());
        $criteria = new Criteria();
        $criteria->add(new Filter('numero_ocorrencia', '>=', $occurrenceNumber));

        $repository = new Repository(Occurrence::class, true);
        $result = $repository->load($criteria);

        $result = $result ? $result[0] : null;

        Transaction::close();
        return $result;
    }
}