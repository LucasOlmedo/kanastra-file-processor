<?php

namespace App\Infrastructure\Jobs;

use App\Application\UseCases\ProcessDebtUseCase;
use App\Application\UseCases\VerifyDuplicateDebtUseCase;
use App\Infrastructure\Exceptions\ProcessDebtJobFailException;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessChunkDebtDataJob implements ShouldQueue
{
    use Queueable;

    private array $chunkData;

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
        VerifyDuplicateDebtUseCase $verifyDuplicateDebtUseCase
    ): void {
        try {
            foreach ($this->chunkData as $lineData) {
                if ($verifyDuplicateDebtUseCase->execute($lineData))
                    continue;
                $processDebtUseCase->execute($lineData);
            }
        } catch (Exception $e) {
            throw new ProcessDebtJobFailException(
                jobMessage: $e->getMessage(),
                chunkData: $this->chunkData
            );

            $this->fail($e);
        }
    }
}
