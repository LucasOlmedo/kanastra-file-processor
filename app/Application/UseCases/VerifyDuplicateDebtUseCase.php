<?php

namespace App\Application\UseCases;

class VerifyDuplicateDebtUseCase extends DebtUseCase
{
    public function execute(array $data): bool
    {
        $debt = $this->createDebtEntity($data);
        return $this->debtRepository->exists($debt->debtId);
    }
}
