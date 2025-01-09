<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Debt;
use App\Domain\Repositories\DebtRepositoryInterface;

class ProcessDebtUseCase
{
    public function __construct(
        private DebtRepositoryInterface $debtRepository
    ) {}

    public function execute(array $data)
    {
        $debt = $this->createDebtEntity($data);
        return $this->debtRepository->save($debt);
    }

    private function createDebtEntity(array $data)
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
