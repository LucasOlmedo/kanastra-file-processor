<?php

namespace App\Application\Services;

use App\Application\UseCases\ProcessDebtFileUseCase;

class DebtService
{
    public function __construct(
        private ProcessDebtFileUseCase $processDebtFileUseCase
    ) {}

    public function processFile() {}
}
