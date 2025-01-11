<?php

namespace Tests\Unit;

use App\Application\UseCases\ProcessDebtUseCase;
use Illuminate\Support\Str;
use App\Domain\Repositories\DebtRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ProcessDebtUseCaseTest extends TestCase
{
    private $mockDebtRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockDebtRepository = $this->createMock(DebtRepositoryInterface::class);
    }

    public function test_process_debt_success(): void
    {
        $data = [
            [
                'name' => 'John Doe',
                'governmentId' => '123',
                'email' => 'RmL2X@example.com',
                'debtId' => Str::uuid(),
                'debtAmount' => 100,
                'debtDueDate' => '2022-01-01',
            ],
            [
                'name' => 'Jane Doe',
                'governmentId' => '456',
                'email' => 'tZbNt@example.com',
                'debtId' => Str::uuid(),
                'debtAmount' => 200,
                'debtDueDate' => '2022-02-01',
            ]
        ];

        $this->mockDebtRepository->expects($this->once())
            ->method('bulkInsert')
            ->willReturn($data);

        $useCase = new ProcessDebtUseCase($this->mockDebtRepository);
        $result = $useCase->execute($data);

        $this->assertEquals($data[0]['debtId'], $result[0]['debtId']);
    }
}
