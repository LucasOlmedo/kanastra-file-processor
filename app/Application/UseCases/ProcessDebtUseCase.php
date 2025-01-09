<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DebtRepositoryInterface;

class ProcessDebtUseCase
{
    public function __construct(
        private DebtRepositoryInterface $debtRepository
    ) {}

    public function execute() {}
}
