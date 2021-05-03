<?php


namespace App\Modules\Occurrence\Services;


use App\Modules\Occurrence\Infra\Database\Entity\Occurrence;
use App\Modules\Occurrence\Repositories\IOccurrenceRepository;

class ShowOccurrenceService
{
    private IOccurrenceRepository $occurrenceRepository;

    public function __construct(IOccurrenceRepository $occurrenceRepository)
    {
        $this->occurrenceRepository = $occurrenceRepository;
    }

    public function execute(string $occurrenceNumber): ? Occurrence
    {
        return $this->occurrenceRepository->findByNumber($occurrenceNumber);
    }
}