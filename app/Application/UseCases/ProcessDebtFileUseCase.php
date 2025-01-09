<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DebtRepositoryInterface;

class ProcessDebtFileUseCase
{
    public function __construct(
        private DebtRepositoryInterface $debtRepository
    ) {}

    public function execute() {}
}
