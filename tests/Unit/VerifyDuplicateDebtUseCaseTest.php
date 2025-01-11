<?php

namespace Tests\Unit;

use App\Application\UseCases\VerifyDuplicateDebtUseCase;
use App\Domain\Entities\Debt;
use App\Domain\Exceptions\InvalidDebtDataException;
use Illuminate\Support\Str;
use App\Domain\Repositories\DebtRepositoryInterface;
use PHPUnit\Framework\TestCase;

class VerifyDuplicateDebtUseCaseTest extends TestCase
{
    private $mockDebtRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockDebtRepository = $this->createMock(DebtRepositoryInterface::class);
    }

    public function test_verify_duplicate_debt(): void
    {
        $data = [
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
            ]
        ];

        $entities = array_map(fn($d) => $this->mockPartialDebtEntities($d), $data);

        $this->mockDebtRepository
            ->expects($this->any())
            ->method('exists');

        $useCase = new VerifyDuplicateDebtUseCase($this->mockDebtRepository);
        $result = $useCase->execute($data);

        $this->assertEquals($entities[0]->debtId, $result[0]->debtId);
    }

    public function test_verify_duplicate_debt_invalid_data_exception(): void
    {
        $data = [
            [
                'name' => 'John Doe',
                'governmentId' => '123',
                'email' => 'RmL2X.invalid.com',
            ]
        ];

        $this->expectException(InvalidDebtDataException::class);

        $this->mockDebtRepository
            ->expects($this->any())
            ->method('exists');

        $useCase = new VerifyDuplicateDebtUseCase($this->mockDebtRepository);
        $useCase->execute($data);
    }

    private function mockPartialDebtEntities(array $data)
    {
        $debt =  $this->createMock(Debt::class);
        $debt->debtId = $data['debtId'];
        return $debt;
    }
}
