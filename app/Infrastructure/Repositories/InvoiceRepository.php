<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Invoice;
use App\Domain\Repositories\InvoiceRepositoryInterface;
use App\Infrastructure\Exceptions\SaveInvoiceErrorException;
use App\Infrastructure\Mappers\InvoiceMapper;
use Exception;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private InvoiceMapper $mapper
    ) {}

    public function save(Invoice $invoice): Invoice
    {
        try {
            $model = $this->mapper->toModel($invoice);
            $model->save();
            return $this->mapper->toEntity($model);
        } catch (Exception $e) {
            throw new SaveInvoiceErrorException(
                detailedError: $e->getMessage(),
                invoice: $invoice
            );
        }
    }
}
