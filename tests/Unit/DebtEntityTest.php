<?php

namespace Tests\Unit;

use App\Domain\Entities\Debt;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class DebtEntityTest extends TestCase
{
    public function test_debt_create_instance(): void
    {
        $data = $this->debtMockData();

        $debtEntity = new Debt(
            name: $data['name'],
            governmentId: $data['governmentId'],
            email: $data['email'],
            debtId: $data['debtId'],
            debtAmount: $data['debtAmount'],
            debtDueDate: $data['debtDueDate'],
        );

        $this->assertInstanceOf(Debt::class, $debtEntity);
        $this->assertEquals($data['name'], $debtEntity->name);
        $this->assertEquals($data['governmentId'], $debtEntity->governmentId);
        $this->assertEquals($data['email'], $debtEntity->email);
        $this->assertEquals($data['debtId'], $debtEntity->debtId);
        $this->assertEquals($data['debtAmount'], $debtEntity->debtAmount);
        $this->assertEquals($data['debtDueDate'], $debtEntity->debtDueDate);
    }

    private function debtMockData()
    {
        return [
            'name' => 'John Doe',
            'governmentId' => '123',
            'email' => 'RmL2X@example.com',
            'debtId' => (string) Str::uuid(),
            'debtAmount' => 100,
            'debtDueDate' => '2022-01-01',
        ];
    }
}
