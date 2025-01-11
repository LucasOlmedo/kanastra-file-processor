<?php

namespace App\Application\UseCases;

class VerifyDuplicateDebtUseCase extends DebtUseCase
{
    public function execute(array $data): array
    {
        $mappedDebtEntities = array_map(function (array $debt) {
            $debtEntity = $this->createDebtEntity($debt);
            return !$this->debtRepository->exists($debtEntity->debtId) ? $debtEntity : null;
        }, $data);

        return array_filter($mappedDebtEntities);
    }
}
