<?php

namespace App\Application\Services;

use App\Application\UseCases\GenerateInvoiceUseCase;
use App\Application\UseCases\ProcessDebtUseCase;
use App\Application\UseCases\SendInvoiceEmailUseCase;
use App\Application\UseCases\VerifyDuplicateDebtUseCase;
use App\Infrastructure\Jobs\ProcessChunkDebtDataJob;
use App\Infrastructure\Services\ProcessDebtFileService;

class DebtService
{
    public function __construct(
        private ProcessDebtFileService $processDebtFileService,
        private ProcessDebtUseCase $processDebtUseCase,
        private VerifyDuplicateDebtUseCase $verifyDuplicateDebtUseCase,
        private GenerateInvoiceUseCase $generateInvoiceUseCase,
        private SendInvoiceEmailUseCase $sendInvoiceEmailUseCase
    ) {}

    public function processFile(string $filePath)
    {
        $chunkFile = $this->processDebtFileService->readAndChunkDebtFile($filePath);
        foreach ($chunkFile as $chunk) {
            ProcessChunkDebtDataJob::dispatch($chunk);
        }
    }

    public function processFileManually(string $filePath)
    {
        $chunkFile = $this->processDebtFileService->readAndChunkDebtFile($filePath);
        foreach ($chunkFile as $chunk) {
            $uniqueChunk = $this->verifyDuplicateDebtUseCase->execute($chunk);
            $debts = $this->processDebtUseCase->execute($uniqueChunk);
            $invoices = $this->generateInvoiceUseCase->execute($debts);
            $this->sendInvoiceEmailUseCase->execute($invoices);
        }
    }
}
