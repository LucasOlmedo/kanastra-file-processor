<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Debt;

interface DebtRepositoryInterface
{
    public function bulkInsert(array $debtEntities);
    public function exists(string $debtId): bool;
}
