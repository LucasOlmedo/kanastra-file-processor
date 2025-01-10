<?php

namespace App\Application\UseCases;

class ProcessDebtUseCase extends DebtUseCase
{
    public function execute(array $data)
    {
        $debt = $this->createDebtEntity($data);
        return $this->debtRepository->save($debt);
    }
}
