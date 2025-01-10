<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class InvoiceEmailErrorException extends Exception
{
    public function __construct(string $invoiceDebtId)
    {
        parent::__construct("Error sending invoice email: - {$invoiceDebtId}", 500);
    }
}
