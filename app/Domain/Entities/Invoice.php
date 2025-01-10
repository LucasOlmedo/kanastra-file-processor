<?php

namespace App\Domain\Entities;

class Invoice
{
    public string $debtId;
    public string $dueDate;
    public string $barcode;

    public function __construct(
        string $debtId,
        string $dueDate,
        ?string $barcode
    ) {
        $this->debtId = $debtId;
        $this->dueDate = $dueDate;
        $this->barcode = $barcode ?? $this->generateBarcode();
    }

    public function generateBarcode(): string
    {
        return '237' . substr(md5($this->debtId), 0, 36);
    }
}
