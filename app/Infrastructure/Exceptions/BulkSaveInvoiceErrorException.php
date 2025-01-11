<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BulkSaveInvoiceErrorException extends Exception
{
    public function __construct(string $detailedError = '', array $invoices = [])
    {
        $message = "Error saving invoice: - {$detailedError}";

        parent::__construct($message, 500);

        Log::error($message, [
            'invoice_list' => $invoices,
        ]);
    }
}
