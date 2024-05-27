<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ принят</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #28a745;
        }

        p {
            font-size: 16px;
            color: #333333;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ваш заказ был принят</h1>
        <p>Здравствуйте,
            @if ($order->order_user)
                {{ $order->order_user->name }} {{ $order->order_user->lastname }}
            @else
                {{ $order->name }} {{ $order->surname ?? '' }}
            @endif
        </p>
        <p>Ваш заказ с Номером <span class="text-danger">{{ $order->id }}</span> был выполнен</p>
        <p>Наш номер телефона +7(937) 321-51-40</p>
        <p>"Чистый дом"</p>
    </div>
</body>

</html>
