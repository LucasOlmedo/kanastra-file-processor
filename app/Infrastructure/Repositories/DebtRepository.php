<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Debt;
use App\Models\Debt as DebtModel;
use App\Domain\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Exceptions\BulkSaveDebtErrorException;
use App\Infrastructure\Mappers\DebtMapper;
use Exception;

class DebtRepository implements DebtRepositoryInterface
{
    public function __construct(
        private DebtMapper $debtMapper
    ) {}

    public function bulkInsert(array $debtData): array
    {
        try {
            $debtArray = array_map(fn($data) => $this->debtMapper->toArray($data), $debtData);
            DebtModel::insert($debtArray);
            return $debtData;
        } catch (Exception $e) {
            throw new BulkSaveDebtErrorException(
                detailedError: $e->getMessage(),
                debts: $debtData
            );
        }
    }

    public function exists(string $debtId): bool
    {
        return DebtModel::whereUuid($debtId)->exists();
    }
}
