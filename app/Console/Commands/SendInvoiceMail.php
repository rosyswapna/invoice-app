<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Jobs\GenerateInvoicePdf;
use App\Jobs\SendInvoiceEmail;

class SendInvoiceMail extends Command
{
    protected $signature = 'app:send-invoice-mail';
    protected $description = 'Generate and email pending invoices at the end of each month';

    public function handle()
    {
        $this->info('Starting monthly invoice processing...');

        $invoices = Invoice::where('status', 'Pending')->get();

        foreach ($invoices as $invoice) {
            GenerateInvoicePdfJob::dispatch($invoice->id)
                ->chain([
                    new SendInvoiceEmailJob($invoice->id),
                ]);
        }

        $this->info('Monthly invoice jobs dispatched successfully!');
    }
}
