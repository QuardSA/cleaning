<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заказ успешно размещен</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Заказ успешно размещен</h1>

                        <p>Здравствуйте,{{ $user->surname }} {{ $user->name }} {{ $user->lastname }},</p>

                        <p>Ваш заказ с номером {{ $order->id }} успешно размещен.</p>

                        <p>Сумма вашего заказа: {{ $order->cost }} рублей.</p>

                        <p>Вы заказали услугу: {{ $order->order_service->titleservice }}</p>

                        <p>Дополнительные услуги:
                            @forelse ($order->additionalServices as $additionalService)
                                {{ $additionalService->titleadditionalservices }}
                            @empty
                                Доп.услуги отсутствуют
                            @endforelse
                        </p>
                        <p>Время начала работ: {{$order->start_time}} </p>

                        <p>Спасибо, что выбрали "Чистый дом"!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
