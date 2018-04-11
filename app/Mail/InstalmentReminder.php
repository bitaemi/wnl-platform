<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstalmentReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;

	/**
	 * Create a new message instance.
	 *
	 * @param Order $order
	 */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
			->subject("Zbliża się termin kolejnej raty (Zamówienie {$this->order->id})")
			->view('mail.payment-reminder-instalment');
    }
}
