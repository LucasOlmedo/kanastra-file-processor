<?php

namespace Tests\Unit;

use App\Domain\Entities\Invoice;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class InvoiceEntityTest extends TestCase
{
    public function test_invoice_create_instance(): void
    {
        $data = $this->debtMockData();

        $invoiceEntity = new Invoice(
            debtId: $data['debtId'],
            dueDate: $data['dueDate'],
            barcode: $data['barcode'],
        );

        $this->assertInstanceOf(Invoice::class, $invoiceEntity);
        $this->assertEquals($data['debtId'], $invoiceEntity->debtId);
        $this->assertEquals($data['dueDate'], $invoiceEntity->dueDate);
        $this->assertEquals($data['barcode'], $invoiceEntity->barcode);
    }

    public function test_invoice_generate_barcode(): void
    {
        $uuid = (string) Str::uuid();
        $expectedBarcode = '237' . substr(md5($uuid), 0, 36);

        $invoiceEntity = new Invoice(
            debtId: $uuid,
            dueDate: '2022-01-01',
            barcode: null,
        );

        $invoiceEntity->generateBarcode();

        $this->assertInstanceOf(Invoice::class, $invoiceEntity);
        $this->assertNotNull($invoiceEntity->barcode);
        $this->assertEquals($expectedBarcode, $invoiceEntity->barcode);
    }

    private function debtMockData()
    {
        return [
            'debtId' => (string) Str::uuid(),
            'dueDate' => '2022-01-01',
            'barcode' => '123456789',
        ];
    }
}
