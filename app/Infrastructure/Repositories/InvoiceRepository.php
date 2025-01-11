<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\InvoiceRepositoryInterface;
use App\Infrastructure\Exceptions\BulkSaveInvoiceErrorException;
use App\Infrastructure\Mappers\InvoiceMapper;
use App\Infrastructure\Services\SendInvoiceEmailService;
use App\Models\Invoice as InvoiceModel;
use Exception;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(
        private InvoiceMapper $mapper,
        private SendInvoiceEmailService $sendInvoiceEmailService
    ) {}

    public function bulkInsert(array $invoicesData): array
    {
        try {
            $debtArray = array_map(fn($data) => $this->mapper->toArray($data), $invoicesData);
            InvoiceModel::insert($debtArray);
            return $invoicesData;
        } catch (Exception $e) {
            throw new BulkSaveInvoiceErrorException(
                detailedError: $e->getMessage(),
                invoices: $invoicesData
            );
        }
    }
}
