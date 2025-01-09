<?php

namespace App\Domain\Entities;

class Debt
{
    public string $name;
    public string $governmentId;
    public string $email;
    public int $amount;
    public string $dueDate;
    public string $uuid;

    public function __construct(
        string $name,
        string $governmentId,
        string $email,
        int $amount,
        string $dueDate,
        string $uuid
    ) {
        $this->name = $name;
        $this->governmentId = $governmentId;
        $this->email = $email;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        $this->uuid = $uuid;
    }
}
