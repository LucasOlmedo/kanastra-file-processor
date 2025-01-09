<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Mappers\EntityMapperInterface;

class DebtMapper implements EntityMapperInterface
{
    public function toEntity(object $model): object
    {
        return $model;
    }

    public function toModel(object $entity): object
    {
        return $entity;
    }
}
