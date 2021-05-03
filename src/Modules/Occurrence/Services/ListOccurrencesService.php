<?php


namespace App\Modules\Occurrence\Services;


use App\Modules\Occurrence\Repositories\IOccurrenceRepository;

class ListOccurrencesService
{
    private IOccurrenceRepository $occurrenceRepository;

    public function __construct(IOccurrenceRepository $occurrenceRepository)
    {
        $this->occurrenceRepository = $occurrenceRepository;
    }

    public function execute(): array
    {
        return $this->occurrenceRepository->load();
    }
}