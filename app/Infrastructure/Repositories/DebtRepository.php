<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Debt;
use App\Models\Debt as DebtModel;
use App\Domain\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Mappers\DebtMapper;
use Illuminate\Support\Facades\Log;

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
        } catch (\Exception $e) {
            Log::error("Error saving debt: " . $e->getMessage(), [
                'entity' => $entity,
            ]);
            throw $e;
        }
    }

    public function exists(string $debtId): bool
    {
        return DebtModel::whereUuid($debtId)->exists();
    }
}
