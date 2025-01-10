<?php

namespace Tests\Feature;

use App\Domain\Entities\Invoice;
use App\Infrastructure\Exceptions\InvoiceEmailErrorException;
use App\Infrastructure\Services\SendInvoiceEmailService;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenerateInvoiceWithEmailTest extends TestCase
{
    private $mockEmailService;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockEmailService = $this->createMock(SendInvoiceEmailService::class);
    }

    public function test_send_invoice_email_success()
    {
        $invoice = $this->createInvoice();

        $this->mockEmailService
            ->expects($this->once())
            ->method('sendInvoiceEmail');

        $this->mockEmailService->sendInvoiceEmail($invoice);
    }

    public function test_send_invoice_email_error_exception()
    {
        $invoice = $this->createInvoice();

        $this->mockEmailService
            ->expects($this->once())
            ->method('sendInvoiceEmail')
            ->will($this->throwException(new InvoiceEmailErrorException($invoice->debtId)));

        $this->expectException(InvoiceEmailErrorException::class);

        $this->mockEmailService->sendInvoiceEmail($invoice);
    }

    private function createInvoice(): Invoice
    {
        $invoice = new Invoice(
            debtId: (string) Str::uuid(),
            dueDate: '2022-01-01',
            barcode: null
        );
        $invoice->generateBarcode();
        return $invoice;
    }
}
