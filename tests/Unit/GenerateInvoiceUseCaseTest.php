<?php

namespace Tests\Unit;

use App\Application\UseCases\GenerateInvoiceUseCase;
use App\Domain\Entities\Debt;
use App\Domain\Entities\Invoice;
use App\Domain\Repositories\InvoiceRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class GenerateInvoiceUseCaseTest extends TestCase
{
    private $mockInvoiceRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockInvoiceRepository = $this->createMock(InvoiceRepositoryInterface::class);
    }

    public function test_generate_invoice_success()
    {
        $debtEntityMock = $this->createPartialDebtEntityMock();
        $invoiceEntityMock = $this->createInvoiceEntityMock($debtEntityMock);

        $this->mockInvoiceRepository->expects($this->once())
            ->method('bulkInsert')
            ->willReturn($invoiceEntityMock);

        $useCase = new GenerateInvoiceUseCase($this->mockInvoiceRepository);
        $useCase->execute($debtEntityMock);

        $this->assertInstanceOf(Invoice::class, $invoiceEntityMock[0]);
        $this->assertEquals($debtEntityMock[0]->debtId, $invoiceEntityMock[0]->debtId);
        $this->assertEquals($debtEntityMock[0]->debtDueDate, $invoiceEntityMock[0]->dueDate);
        $this->assertNotNull($invoiceEntityMock[0]->barcode);
    }

    private function createInvoiceEntityMock(array $debts)
    {
        $invoices = [];

        foreach ($debts as $debt) {
            $invoice = new Invoice(
                debtId: $debt->debtId,
                dueDate: $debt->debtDueDate,
                barcode: null
            );
            $invoice->generateBarcode();
            $invoices[] = $invoice;
        }

        return $invoices;
    }

    private function createPartialDebtEntityMock()
    {
        $debts = [];

        for ($i = 0; $i < 5; $i++) {
            $debt = $this->createMock(Debt::class);
            $debt->debtId = (string) Str::uuid();
            $debt->debtDueDate = fake()->date('Y-m-d');
            $debts[] = $debt;
        }

        return $debts;
    }
}
