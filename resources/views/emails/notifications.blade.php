<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заказ успешно размещен</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
        }

        .card-title {
            font-size: 24px;
            color: #007bff;
        }

        p {
            font-size: 16px;
            color: #333333;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Заказ успешно размещен</h1>
                <p>Здравствуйте, @if ($order->order_user)
                        {{ $order->order_user->name }} {{ $order->order_user->lastname }}
                    @else
                        {{ $order->name }} {{ $order->surname ?? '' }}
                    @endif
                    .</p>
                <p>Ваш заказ с номером <span class="text-danger">{{ $order->id }}</span> успешно
                    размещен.</p>
                <p>Сумма вашего заказа: <span class="text-success">{{ $order->cost }} рублей.</span></p>
                <p>Вы заказали услугу: {{ $order->order_service->titleservice }}</p>
                <p>Дополнительные услуги:
                    @forelse ($order->additionalServices as $additionalService)
                        {{ $additionalService->titleadditionalservices }}
                    @empty
                        Доп.услуги отсутствуют
                    @endforelse
                </p>
                <p>Время начала работ: {{ \Carbon\Carbon::parse($order->start_time)->format('d-m-y H:i') }} </p>
                <p>Наш номер телефона +7(937) 321-51-40</p>
                <p>Спасибо, что выбрали "Чистый дом"!</p>
            </div>
        </div>
    </div>
</body>

</html>
