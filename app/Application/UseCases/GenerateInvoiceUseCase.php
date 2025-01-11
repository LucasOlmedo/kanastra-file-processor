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

    public function execute(array $debts): array
    {
        $invoices = array_map(fn(Debt $debt) => $this->createInvoiceEntity($debt), $debts);
        return $this->invoiceRepository->bulkInsert($invoices);
    }

    private function createInvoiceEntity(Debt $debt)
    {
        return new Invoice(
            debtId: $debt->debtId,
            dueDate: $debt->debtDueDate,
            barcode: null
        );
    }
}
