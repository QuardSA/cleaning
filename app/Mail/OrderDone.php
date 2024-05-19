<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class OrderDone extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     */
    public function __construct($order, )
    {
        $this->order = $order;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заказ выполнен',
        );
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.order_done')
                    ->with(['order' => $this->order]);
    }
}
