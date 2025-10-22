<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\InvoicePdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateInvoicePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function handle(InvoicePdfService $pdfService)
    {
        // 1️⃣ Update status to InProgress
        $this->invoice->status = 'InProgress';
        $this->invoice->save();

        // 2️⃣ Generate PDF
        $pdfPath = $pdfService->generatePdf($this->invoice);

        // 3️⃣ Update invoice with PDF path and mark PDF as generated
        $this->invoice->pdf_path = $pdfPath;
        $this->invoice->status = 'Generated';
        $this->invoice->save();
    }
}
