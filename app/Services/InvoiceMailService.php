<?php

namespace App\Services;

use App\Models\Invoice;
use App\Services\InvoicePdfService;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class InvoiceMailService
{
    protected $pdfService;

    public function __construct(InvoicePdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Send a single invoice email with PDF attachment.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function sendInvoice(Invoice $invoice)
    {
        // 1️⃣ Generate PDF
        $pdfPath = $this->pdfService->generatePdf($invoice);

        // 2️⃣ Send email
        Mail::to($invoice->customer_email)
            ->send(new InvoiceMail($invoice, $pdfPath));

        // 3️⃣ Update invoice status (optional)
        $invoice->status = 'Sent';
        $invoice->save();
    }

    /**
     * Send multiple invoices in bulk
     *
     * @param \Illuminate\Support\Collection $invoices
     * @return void
     */
    public function sendBulkInvoices()
    {

        Invoice::where('status', 'Generated')->chunk(50, function ($invoices) {
            foreach ($invoices as $invoice) {
                $this->sendInvoice($invoice);

                // Update status to 'Send' 
                $invoice->status = 'Send';
                $invoice->save();
            }
        });

        
    }
}
