<?php

namespace App\Domain\Repositories;

interface DebtRepositoryInterface
{
    public function bulkInsert(array $debtEntities);
    public function exists(string $debtId): bool;
}
