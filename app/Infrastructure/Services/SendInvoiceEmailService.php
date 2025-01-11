<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\Invoice;
use App\Infrastructure\Exceptions\InvoiceEmailErrorException;
use Exception;
use Illuminate\Support\Facades\Log;

class SendInvoiceEmailService
{
    public function sendInvoiceEmail(Invoice $invoice): void
    {
        try {
            Log::info('Sending invoice email...', [
                'invoice_debt_id' => $invoice->debtId,
                'invoice_due_date' => $invoice->dueDate,
                'invoice_barcode' => $invoice->barcode,
            ]);
        } catch (Exception $e) {

            Log::error('Error sending invoice email', [
                'error' => $e->getMessage(),
                'invoice_debt_id' => $invoice->debtId,
            ]);

            throw new InvoiceEmailErrorException($invoice->debtId);
        }
    }
}
