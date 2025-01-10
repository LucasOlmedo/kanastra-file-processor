<?php

namespace App\Application\UseCases;

class ProcessDebtUseCase extends DebtUseCase
{
    public function execute(array $data)
    {
        if (!$this->validateData($data))
            throw new \InvalidArgumentException("Invalid data: " . json_encode($data));

        $debt = $this->createDebtEntity($data);
        return $this->debtRepository->save($debt);
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
