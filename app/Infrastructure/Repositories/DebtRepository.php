<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Debt;
use App\Domain\Repositories\DebtRepositoryInterface;

class DebtRepository implements DebtRepositoryInterface
{
    public function save(Debt $entity): Debt
    {
        return $entity;
    }
}
