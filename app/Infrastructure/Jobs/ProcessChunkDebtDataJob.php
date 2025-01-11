<?php

namespace App\Infrastructure\Jobs;

use App\Application\UseCases\GenerateInvoiceUseCase;
use App\Application\UseCases\ProcessDebtUseCase;
use App\Application\UseCases\SendInvoiceEmailUseCase;
use App\Application\UseCases\VerifyDuplicateDebtUseCase;
use App\Infrastructure\Exceptions\ProcessDebtJobFailException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessChunkDebtDataJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    private array $chunkData;

    public int $tries = 3;

    public int $retryAfter = 90;

    /**
     * Create a new job instance.
     */
    public function __construct(array $chunkData)
    {
        $this->chunkData = $chunkData;
    }

    /**
     * Execute the job.
     */
    public function handle(
        ProcessDebtUseCase $processDebtUseCase,
        VerifyDuplicateDebtUseCase $verifyDuplicateDebtUseCase,
        GenerateInvoiceUseCase $generateInvoiceUseCase,
        SendInvoiceEmailUseCase $sendInvoiceEmailUseCase
    ): void {
        try {
            DB::beginTransaction();

            $uniqueChunk = $verifyDuplicateDebtUseCase->execute($this->chunkData);
            $debts = $processDebtUseCase->execute($uniqueChunk);
            $invoices = $generateInvoiceUseCase->execute($debts);
            $sendInvoiceEmailUseCase->execute($invoices);

            DB::commit();

            Log::info('Job processed successfully');
        } catch (Exception $e) {
            throw new ProcessDebtJobFailException(
                jobMessage: $e->getMessage(),
                chunkData: $this->chunkData
            );

            DB::rollBack();
            $this->fail($e);
        }
    }

    public function failed(Exception $exception): void
    {
        Log::critical('Job failed', [
            'exception' => $exception->getMessage(),
            'chunk_data' => $this->chunkData,
        ]);

        // Notifications (Slack, Email, etc.)
    }
}
