<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Debt;
use App\Domain\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Mappers\DebtMapper;

class DebtRepository implements DebtRepositoryInterface
{
    public function __construct(
        private DebtMapper $debtMapper
    ) {}

    public function save(Debt $entity): Debt
    {
        $model = $this->debtMapper->toModel($entity);
        $model->save();
        return $this->debtMapper->toEntity($model);
    }
}
