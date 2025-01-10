<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class SaveDebtErrorException extends Exception
{
    public function __construct(string $detailedError = '', object $debt = null)
    {
        $message = "Error saving debt: - {$detailedError}";

        parent::__construct($message, 500);

        Log::error($message, [
            'entity' => $debt,
        ]);
    }
}
