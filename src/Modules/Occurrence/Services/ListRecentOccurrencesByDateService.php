<?php


namespace App\Modules\Occurrence\Services;

use App\Shared\Errors\ApiException;
use Exception;
use App\Modules\Occurrence\Repositories\IOccurrenceRepository;

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
        // $error = true;
        // if ($error) throw new ApiException('Error: invalid date', 400);
        return $this->occurrenceRepository->loadByDate($date);
    }
}