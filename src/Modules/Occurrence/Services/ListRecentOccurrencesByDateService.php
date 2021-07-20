<?php


namespace App\Modules\Occurrence\Services;

use App\Modules\Occurrence\Repositories\IOccurrenceRepository;
use Exception;

class ListRecentOccurrencesByDateService
{
    private IOccurrenceRepository $occurrenceRepository;

    public function __construct(IOccurrenceRepository $occurrenceRepository)
    {
        $this->occurrenceRepository = $occurrenceRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $date): array
    {
        return $this->occurrenceRepository->loadByDate($date);
    }
}