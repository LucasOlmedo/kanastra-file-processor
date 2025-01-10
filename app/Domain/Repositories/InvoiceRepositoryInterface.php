<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Invoice;

interface InvoiceRepositoryInterface
{
    public function save(Invoice $entity): Invoice;
}
