<?php

namespace App\Domain\Mappers;

interface EntityMapperInterface
{
    public function toEntity(object $model): object;
    public function toModel(object $entity): object;
}
