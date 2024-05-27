<?php

namespace App\Notifications;


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShipped extends Notification
{
    use Queueable;

    protected $order;
    protected $user;

    public function __construct($order, $user = null)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $name = $this->user ? $this->user->name : $this->order->name;
        $surname = $this->user ? $this->user->surname : $this->order->surname;
        $lastname = $this->user ? $this->user->lastname : '';

        return (new MailMessage)
            ->subject('Заказ успешно размещен')
            ->view('emails.notifications', [
                'order' => $this->order,
                'name' => $name,
                'surname' => $surname,
                'lastname' => $lastname,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_cost' => $this->order->cost,
        ];
    }
}
