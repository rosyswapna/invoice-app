<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Mail\InvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function handle()
    {
        if (!file_exists($this->invoice->pdf_path)) {
            // PDF not found, skip sending
            return;
        }

        Mail::to($this->invoice->customer_email)
            ->send(new InvoiceMail($this->invoice, $this->invoice->pdf_path));

        $this->invoice->status = 'Sent';
        $this->invoice->save();
    }
}
