<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Mail\OrderDone;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить статус заказа на «Выполнено», если время работы истекло';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();


        $orders = Order::where('status', 2)
            ->where('end_time', '<=', $now)
            ->get();

        $this->info('Найдено заказов для обновления: ' . $orders->count());

        foreach ($orders as $order) {
            $order->status = 5;
            $order->save();


            $orderUser = $order->order_user;
            Mail::to($orderUser->email)->send(new OrderDone($order));


            Log::info('Автоматическое обновление заказа на выполнено', [
                'order_id' => $order->id,
                'user_email' => $orderUser->email,
                'action' => 'Заказ выполнен автоматически',
            ]);
        }

        $this->info('Статусы заказов обновлены, электронные письма успешно отправлены!');
    }
}
