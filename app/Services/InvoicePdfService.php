<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfService
{
    public function generatePdf(Invoice $invoice): string
    {
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice
        ]);

        $filePath = storage_path("app/public/invoices/invoice_{$invoice->id}.pdf");
        $pdf->save($filePath);

        return $filePath;
    }
}
