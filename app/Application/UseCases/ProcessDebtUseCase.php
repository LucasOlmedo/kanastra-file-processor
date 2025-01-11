<?php

namespace App\Application\UseCases;

class ProcessDebtUseCase extends DebtUseCase
{
    public function execute(array $batch): array
    {
        return $this->debtRepository->bulkInsert($batch);
    }
}
