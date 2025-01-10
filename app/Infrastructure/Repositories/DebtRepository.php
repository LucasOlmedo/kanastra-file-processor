<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Debt;
use App\Models\Debt as DebtModel;
use App\Domain\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Mappers\DebtMapper;

class DebtRepository implements DebtRepositoryInterface
{
    public function __construct(
        private DebtMapper $debtMapper
    ) {}

    public function save(Debt $entity): Debt
    {
        try {
            $model = $this->debtMapper->toModel($entity);
            $model->save();
            return $this->debtMapper->toEntity($model);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function exists(string $debtId): bool
    {
        return DebtModel::whereUuid($debtId)->exists();
    }
}
