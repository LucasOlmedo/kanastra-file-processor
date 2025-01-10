<?php

namespace Tests\Unit;

use App\Application\UseCases\VerifyDuplicateDebtUseCase;
use Illuminate\Support\Str;
use App\Domain\Repositories\DebtRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VerifyDuplicateDebtUseCaseTest extends TestCase
{
    private $mockDebtRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockDebtRepository = $this->createMock(DebtRepositoryInterface::class);
    }

    #[DataProvider('debtDataProvider')]
    public function test_verify_duplicate_debt_with_data_provider($data, $expected): void
    {
        $this->mockDebtRepository->expects($this->once())
            ->method('exists')
            ->with($data['debtId'])
            ->willReturn($expected);

        $useCase = new VerifyDuplicateDebtUseCase($this->mockDebtRepository);
        $result = $useCase->execute($data);

        $this->assertEquals($expected, $result);
    }

    public static function debtDataProvider(): array
    {
        return [
            'debt_exists' => [
                'data' => [
                    'name' => 'John Doe',
                    'governmentId' => '123',
                    'email' => 'RmL2X@example.com',
                    'debtId' => (string) Str::uuid(),
                    'debtAmount' => 100,
                    'debtDueDate' => '2022-01-01',
                ],
                'expected' => true
            ],
            'debt_does_not_exist' => [
                'data' => [
                    'name' => 'Jane Doe',
                    'governmentId' => '456',
                    'email' => 'jane@example.com',
                    'debtId' => 'abcd-1234-5678-abcd',
                    'debtAmount' => 200,
                    'debtDueDate' => '2022-02-01',
                ],
                'expected' => false
            ],
        ];
    }
}
