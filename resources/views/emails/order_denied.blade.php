<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отказ от заказа</title>
</head>
<body>
    <h1>Ваш заказ был отклонен</h1>
    <p>Здравствуйте, {{ $order->order_user->name }} {{ $order->order_user->surname }} {{ $order->order_user->lastname }}</p>
    <p>Ваш заказ с Номером {{ $order->id }} был отклонен по следующей причине:</p>
    <p>{{ $reason }}</p>
    <p>С уважением,<br>"Чистый дом"</p>
</body>
</html>
