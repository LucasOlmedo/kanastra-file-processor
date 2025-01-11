<?php

namespace App\Application\UseCases;


use App\Domain\Entities\Invoice;
use App\Infrastructure\Services\SendInvoiceEmailService;

class SendInvoiceEmailUseCase
{
    public function __construct(
        private SendInvoiceEmailService $sendInvoiceEmailService
    ) {}

    public function execute(array $invoices): void
    {
        foreach ($invoices as $invoice) {
            $this->sendInvoiceEmailService->sendInvoiceEmail($invoice);
        }
    }
}
