<?php

namespace App\Infrastructure\Jobs;

use App\Application\UseCases\ProcessDebtUseCase;
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
    public function handle(ProcessDebtUseCase $processDebtUseCase): void
    {
        foreach ($this->chunkData as $lineData) {
            $processDebtUseCase->execute($lineData);
        }
    }
}
