<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Mappers\EntityMapperInterface;
use App\Domain\Entities\Invoice as InvoiceEntity;
use App\Models\Invoice as InvoiceModel;

class InvoiceMapper implements EntityMapperInterface
{
    public function toEntity(object $model): object
    {
        if (!$model instanceof InvoiceModel)
            throw new \Exception('Model must be an instance of Debt');

        return new InvoiceEntity(
            debtId: $model->debt_id,
            dueDate: $model->due_date,
            barcode: $model->barcode
        );
    }

    public function toModel(object $entity): object
    {
        if (!$entity instanceof InvoiceEntity)
            throw new \Exception('Entity must be an instance of Debt');

        $model = InvoiceModel::firstOrNew(['debt_id' => $entity->debtId]);
        $model->due_date = $entity->dueDate;
        $model->barcode = $entity->barcode;

        return $model;
    }
}
