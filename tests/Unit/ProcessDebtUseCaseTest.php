<?php

namespace Tests\Unit;

use App\Application\UseCases\ProcessDebtUseCase;
use App\Domain\Entities\Debt;
use App\Domain\Exceptions\InvalidDebtDataException;
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
        $debtEntityMock = $this->createDebtEntityMock();
        $this->mockDebtRepository->expects($this->once())
            ->method('save')
            ->willReturn($debtEntityMock);

        $useCase = new ProcessDebtUseCase($this->mockDebtRepository);
        $result = $useCase->execute([
            'name' => 'John Doe',
            'governmentId' => '123',
            'email' => 'RmL2X@example.com',
            'debtId' => $debtEntityMock->debtId,
            'debtAmount' => 100,
            'debtDueDate' => '2022-01-01',
        ]);

        $this->assertInstanceOf(Debt::class, $result);
    }

    public function test_process_debt_failure(): void
    {
        $this->expectException(InvalidDebtDataException::class);
        $useCase = new ProcessDebtUseCase($this->mockDebtRepository);
        $useCase->execute([
            'name' => 'John Doe',
            'governmentId' => '123',
            'email' => 'invalid.email',
            'debtId' => 'invalid-debt-id',
            'debtAmount' => 100,
            'debtDueDate' => '2022-01-01',
        ]);
    }

    private function createDebtEntityMock()
    {
        $debt = $this->createMock(Debt::class);
        $debt->name = 'John Doe';
        $debt->governmentId = '123';
        $debt->email = 'RmL2X@example.com';
        $debt->debtId = (string) Str::uuid();
        $debt->debtAmount = 100;
        $debt->debtDueDate = '2022-01-01';
        return $debt;
    }
}
