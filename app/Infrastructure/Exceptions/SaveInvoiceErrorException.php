<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SaveInvoiceErrorException extends Exception
{
    public function __construct(string $detailedError = '', object $invoice = null)
    {
        $message = "Error saving invoice: - {$detailedError}";

        parent::__construct($message, 500);

        Log::error($message, [
            'entity' => $invoice,
        ]);
    }
}
