<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <x-links></x-links>
</head>
<x-header></x-header>

<body class="d-flex flex-column" style="min-height: 102vh">
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="card border-info">
                    <div class="card-header border-info bg-white fw-semibold">
                        Меню
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-info">
                            <a href="/personal" class="text-decoration-none text-dark">Мои заказы</a>
                        </li>
                        <li class="list-group-item border-info">
                            <a href="/profile" class="text-decoration-none text-dark">Настройки профиля</a>
                        </li>
                        <li class="list-group-item border-info">
                            <a href="/signout" class="text-decoration-none text-dark">Выйти</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 mt-2">
                <div class="card border-info">
                    <div class="card-header border-info bg-white fw-semibold">
                        Мои заказы
                    </div>
                    @forelse ($orders as $order)
                        <div class="card-body">
                            <div class="card border-info">
                                <div class="card-header border-info bg-white fw-semibold">
                                    Заказ № {{ $order->id }}
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Заказ на число:</strong>
                                            {{ \Carbon\Carbon::parse($order->start_time)->format('d.m.Y') }}
                                        </li>
                                        <li class="list-group-item"><strong>Услуга:</strong>
                                            {{ $order->order_service->titleservice }}</li>
                                        <li class="list-group-item"><strong>Дополнительные услуги:</strong>
                                            @forelse ($order->additionalServices as $additionalService)
                                                {{ $additionalService->titleadditionalservices }}
                                            @empty
                                                Доп.услуги отсутствуют
                                            @endforelse
                                        </li>
                                        <li class="list-group-item"><strong>Адрес:</strong> {{ $order->address }}</li>
                                        <li class="list-group-item">
                                            <strong>Минимальное время работы:</strong>
                                            от {{ $order->formatted_work_time }}
                                        </li>
                                        <li class="list-group-item"><strong>Сумма в итоге:</strong>
                                            {{ $order->cost }} руб</li>
                                        <li class="list-group-item"><strong>Статус:</strong>
                                            {{ $order->order_orderstatus->titlestatus }}</li>
                                    </ul>
                                    @if ($order->status !== 4 && $order->status !== 3 && $order->status !== 5)
                                        <form action="{{ route('cancel-order', $order->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger rounded-pill">Отменить
                                                заказ</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">Вы не делали заказы!</div>
                    @endforelse

                    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    <x-alerts></x-alerts>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</html>
