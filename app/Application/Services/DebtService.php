<?php

namespace App\Application\Services;

use App\Application\UseCases\ProcessDebtUseCase;
use App\Infrastructure\Jobs\ProcessChunkDebtDataJob;
use App\Infrastructure\Services\ProcessDebtFileService;

class DebtService
{
    public function __construct(
        private ProcessDebtFileService $processDebtFileService,
        private ProcessDebtUseCase $processDebtUseCase
    ) {}

    public function processFile(string $filePath)
    {
        $chunkFile = $this->processDebtFileService->readAndChunkDebtFile($filePath);
        foreach ($chunkFile as $chunk) {
            foreach ($chunk as $line) {
                $this->processDebtUseCase->execute($line);
            }
            // ProcessChunkDebtDataJob::dispatch($chunk);
        }
    }
}
