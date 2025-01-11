<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BulkSaveDebtErrorException extends Exception
{
    public function __construct(string $detailedError = '', array $debts = [])
    {
        $message = "Error saving debt: - {$detailedError}";

        parent::__construct($message, 500);

        Log::error($message, [
            'debt_list' => $debts,
        ]);
    }
}
