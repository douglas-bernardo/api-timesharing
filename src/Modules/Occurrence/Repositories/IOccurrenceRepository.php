<?php


namespace App\Modules\Occurrence\Repositories;



use App\Modules\Occurrence\Infra\Database\Entity\Occurrence;

interface IOccurrenceRepository
{
    public function load(): array;
    public function loadByNumber(string $OccurrenceNumber): array;
    public function loadByDate(string $date): array;
    public function findByNumber(string $occurrenceNumber): ? Occurrence;
}