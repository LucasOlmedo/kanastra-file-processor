<?php

namespace App\Application\Services;

use App\Infrastructure\Jobs\ProcessChunkDebtDataJob;
use App\Infrastructure\Services\ProcessDebtFileService;

class DebtService
{
    public function __construct(
        private ProcessDebtFileService $processDebtFileService
    ) {}

    public function processFile(string $filePath)
    {
        $chunkFile = $this->processDebtFileService->readAndChunkDebtFile($filePath);
        foreach ($chunkFile as $chunk) {
            ProcessChunkDebtDataJob::dispatch($chunk);
        }
    }
}
