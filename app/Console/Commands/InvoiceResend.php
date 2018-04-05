<?php

namespace App\Console\Commands;

use App\Mail\ResendInvoice;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Lib\Invoice\Invoice as InvoiceGenerator;
use Illuminate\Support\Facades\Mail;

class InvoiceResend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:resend {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render, save to PDF and send again one or more invoices.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (explode(',', $this->argument('id')) as $invoiceId) {
        	$invoice = Invoice::find($invoiceId);
        	if (!$invoice) {
        		$this->warn("Can't find invoice of id {$invoiceId}");
			}

			(new InvoiceGenerator)->proforma($invoice->order, $invoice);

			Mail::to($invoice->order->user)->send(new ResendInvoice($invoice->order, $invoice));
		}

		return;
    }
}
