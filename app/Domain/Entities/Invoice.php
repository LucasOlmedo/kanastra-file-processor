<?php

namespace App\Domain\Entities;

class Invoice
{
    public int $id;
    public string $debtUuid;
    public string $generateDate;
    public string $status;

    public function __construct(
        int $id,
        string $debtUuid,
        string $generateDate,
        string $status
    ) {
        $this->id = $id;
        $this->debtUuid = $debtUuid;
        $this->generateDate = $generateDate;
        $this->status = $status;
    }
}
