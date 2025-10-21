<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Services\InvoicePdfService;

class GenerateInvoicePdf implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(InvoicePdfService $service): void
    {
        //generate pdf and save
        $paths = $service->generateBulkPdf();
    }
}
