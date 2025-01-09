<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Debt;

interface DebtRepositoryInterface
{
    public function save(Debt $entity): Debt;
}
