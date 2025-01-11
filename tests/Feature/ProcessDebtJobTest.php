<?php

namespace Tests\Feature;

use App\Infrastructure\Jobs\ProcessChunkDebtDataJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessDebtJobTest extends TestCase
{
    public function test_dispatch_process_debt_job(): void
    {
        Queue::fake();

        $chunk = [
            [
                'name' => 'John Doe',
                'governmentId' => '123',
                'email' => 'RmL2X@example.com',
                'debtId' => (string) Str::uuid(),
                'debtAmount' => 100,
                'debtDueDate' => '2022-01-01',
            ],
            [
                'name' => 'Jane Doe',
                'governmentId' => '456',
                'email' => 'jane@example.com',
                'debtId' => (string) Str::uuid(),
                'debtAmount' => 200,
                'debtDueDate' => '2022-02-01',
            ],
        ];

        ProcessChunkDebtDataJob::dispatch($chunk);
        Queue::assertPushed(ProcessChunkDebtDataJob::class);
    }
}
