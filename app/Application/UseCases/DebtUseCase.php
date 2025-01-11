<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DebtRepositoryInterface;
use App\Domain\Entities\Debt;
use App\Domain\Exceptions\InvalidDebtDataException;

class DebtUseCase
{
    public function __construct(
        protected DebtRepositoryInterface $debtRepository
    ) {}

    protected function createDebtEntity(array $data)
    {
        if (!$this->validateData($data))
            throw new InvalidDebtDataException($data);

        return new Debt(
            name: $data['name'],
            governmentId: $data['governmentId'],
            email: $data['email'],
            debtAmount: $data['debtAmount'],
            debtDueDate: $data['debtDueDate'],
            debtId: $data['debtId']
        );
    }

    private function validateData(array $data): bool
    {
        return isset($data['name'])
            && isset($data['governmentId'])
            && isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)
            && isset($data['debtAmount'])
            && isset($data['debtDueDate'])
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['debtDueDate']) && strtotime($data['debtDueDate'])
            && isset($data['debtId']);
    }
}
