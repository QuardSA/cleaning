<x-header></x-header>
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
                            Заказ № {{$order->id}}
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Заказ на число:</strong> {{$order->date}}</li>
                                <li class="list-group-item"><strong>Услуга:</strong> {{$order->order_service->titleservice}}</li>
                                <li class="list-group-item"><strong>Адрес:</strong> {{$order->address}}</li>
                                <li class="list-group-item"><strong>Статус:</strong> {{$order->order_orderstatus->titlestatus}}</li>
                            </ul>
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

<x-footer></x-footer>
