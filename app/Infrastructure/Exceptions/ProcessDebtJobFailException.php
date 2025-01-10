<?php

namespace App\Infrastructure\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ProcessDebtJobFailException extends Exception
{
    public function __construct(string $jobMessage = '', array $chunkData = [])
    {
        $message = "Error processing chunk: - {$jobMessage}";

        parent::__construct($message, 500);

        Log::error($message, [
            'chunk' => $chunkData,
        ]);
    }
}
