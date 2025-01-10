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
            ->method('save')
            ->willReturn($invoiceEntityMock);

        $useCase = new GenerateInvoiceUseCase($this->mockInvoiceRepository);
        $useCase->execute($debtEntityMock);

        $this->assertInstanceOf(Invoice::class, $invoiceEntityMock);
        $this->assertEquals($debtEntityMock->debtId, $invoiceEntityMock->debtId);
        $this->assertEquals($debtEntityMock->debtDueDate, $invoiceEntityMock->dueDate);
        $this->assertNotNull($invoiceEntityMock->barcode);
    }

    private function createInvoiceEntityMock(Debt $debt)
    {
        $invoice = new Invoice(
            debtId: $debt->debtId,
            dueDate: $debt->debtDueDate,
            barcode: null
        );
        $invoice->generateBarcode();
        return $invoice;
    }

    private function createPartialDebtEntityMock()
    {
        $debt = $this->createMock(Debt::class);
        $debt->debtId = (string) Str::uuid();
        $debt->debtDueDate = '2022-01-01';
        return $debt;
    }
}
