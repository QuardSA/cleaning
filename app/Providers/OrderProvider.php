<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Facades\Validator; // Добавляем эту строку

class OrderProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Validator::extend('unique_with_dates', function ($attribute, $value, $parameters, $validator) {
        //     $date = date('Y-m-d H:i:s', strtotime($value));
        //     $workTime = $parameters[0]; // Получаем время работы из параметров
        //     $start = date('Y-m-d H:i:s', strtotime($date));
        //     $end = date('Y-m-d H:i:s', strtotime($date . ' + ' . $workTime . ' minutes'));
        //     $query = Order::query() // Используем модель Order для выборки данных
        //         ->whereBetween('start_time', [$start, $end]);
        //     if ($parameters[1]) {
        //         // Если передан второй параметр, то добавляем дополнительное условие
        //         $query->where('id', '!=', $parameters[1]);
        //     }
        //     return !$query->exists();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
