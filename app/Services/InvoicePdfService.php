<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoicePdfService
{
    /**
     * Generate PDF for a single invoice and save it.
     *
     * @param Invoice $invoice
     * @param string|null $disk Storage disk, default 'public'
     * @return string File path of generated PDF
     */
    public function generatePdf(Invoice $invoice, $disk = 'public'): string
    {
        // Load the Blade view and pass invoice data
        $pdf = Pdf::loadView('invoice', compact('invoice'));

        // File path
        $filePath = 'invoices/' . $invoice->invoice_number . '.pdf';

        // Save to storage
        Storage::disk($disk)->put($filePath, $pdf->output());

        return $filePath;
    }

    /**
     * Generate PDFs for multiple invoices
     *
     * @param \Illuminate\Support\Collection $invoices
     * @param string|null $disk
     * @return array List of generated file paths
     */
    public function generateBulkPdf(Invoice $invoice, $disk = 'public'): array
    {
        $paths = [];

        $invoices = Invoice::where('status', 'Pending')
                   ->limit(5)
                   ->get();

        foreach ($invoices as $invoice) {
            $paths[] = $this->generatePdf($invoice, $disk);

            // Update status to 'Processed' or any desired status
            $invoice->status = 'Generated';
            $invoice->save();
        }

        return $paths;
    }
}
