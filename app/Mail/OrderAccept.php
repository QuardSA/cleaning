<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderAccept extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdfPathContract;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $pdfPathContract)
    {
        $this->order = $order;
        $this->pdfPathContract = $pdfPathContract;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Заказ принят')
                    ->view('emails.order_accept')
                    ->attach($this->pdfPathContract);
    }
}

