<?php


namespace App\Modules\Occurrence\Services;


use App\Modules\Occurrence\Repositories\IOccurrenceRepository;

class ListRecentOccurrencesByNumberService
{
    private IOccurrenceRepository $occurrenceRepository;

    public function __construct(IOccurrenceRepository $occurrenceRepository)
    {
        $this->occurrenceRepository = $occurrenceRepository;
    }

    public function execute(string $OccurrenceNumber): array
    {
        return $this->occurrenceRepository->loadByNumber($OccurrenceNumber);
    }
}