<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DebtRepositoryInterface;
use App\Domain\Entities\Debt;

class DebtUseCase
{
    public function __construct(
        protected DebtRepositoryInterface $debtRepository
    ) {}

    protected function createDebtEntity(array $data)
    {
        return new Debt(
            name: $data['name'],
            governmentId: $data['governmentId'],
            email: $data['email'],
            debtAmount: $data['debtAmount'],
            debtDueDate: $data['debtDueDate'],
            debtId: $data['debtId']
        );
    }
}
