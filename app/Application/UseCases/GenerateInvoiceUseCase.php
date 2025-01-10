<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Debt;
use App\Domain\Entities\Invoice;
use App\Domain\Repositories\InvoiceRepositoryInterface;

class GenerateInvoiceUseCase
{
    public function __construct(
        protected InvoiceRepositoryInterface $invoiceRepository
    ) {}

    public function execute(Debt $debt): Invoice
    {
        $invoice = new Invoice(
            debtId: $debt->debtId,
            dueDate: $debt->debtDueDate,
            barcode: null
        );
        return $this->invoiceRepository->save($invoice);
    }
}
