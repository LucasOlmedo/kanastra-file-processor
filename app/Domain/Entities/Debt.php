<?php

namespace App\Domain\Entities;

class Debt
{
    public string $name;
    public string $governmentId;
    public string $email;
    public int $debtAmount;
    public string $debtDueDate;
    public string $debtId;

    public function __construct(
        string $name,
        string $governmentId,
        string $email,
        int $debtAmount,
        string $debtDueDate,
        string $debtId
    ) {
        $this->name = $name;
        $this->governmentId = $governmentId;
        $this->email = $email;
        $this->debtAmount = $debtAmount;
        $this->debtDueDate = $debtDueDate;
        $this->debtId = $debtId;
    }
}
