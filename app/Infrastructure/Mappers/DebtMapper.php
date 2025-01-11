<?php

namespace App\Infrastructure\Mappers;

use App\Models\Debt as DebtModel;
use App\Domain\Entities\Debt as DebtEntity;
use App\Domain\Mappers\EntityMapperInterface;

class DebtMapper implements EntityMapperInterface
{
    public function toEntity(object $model): object
    {
        if (!$model instanceof DebtModel)
            throw new \Exception('Model must be an instance of Debt');

        return new DebtEntity(
            name: $model->name,
            governmentId: $model->government_id,
            email: $model->email,
            debtAmount: $model->amount,
            debtDueDate: $model->due_date,
            debtId: $model->uuid
        );
    }

    public function toModel(object $entity): object
    {
        if (!$entity instanceof DebtEntity)
            throw new \Exception('Entity must be an instance of Debt');

        $model = DebtModel::firstOrNew(['uuid' => $entity->debtId]);
        $model->uuid = $entity->debtId;
        $model->name = $entity->name;
        $model->government_id = $entity->governmentId;
        $model->email = $entity->email;
        $model->amount = $entity->debtAmount;
        $model->due_date = $entity->debtDueDate;

        return $model;
    }

    public function toArray(DebtEntity $entity): array
    {
        return [
            'uuid' => $entity->debtId,
            'name' => $entity->name,
            'government_id' => $entity->governmentId,
            'email' => $entity->email,
            'amount' => $entity->debtAmount,
            'due_date' => $entity->debtDueDate,
        ];
    }
}
