<?php

namespace App\Domain\Repositories;

interface InvoiceRepositoryInterface
{
    public function bulkInsert(array $invoiceEntities);
}
