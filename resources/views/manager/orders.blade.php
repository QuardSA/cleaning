<x-admin.header>
</x-admin.header>
<div class="container mt-5">
    <h2 class="text-center mb-4">Заявки</h2>
    <form action="/manager/orders" method="GET">
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="startDateFilter" class="form-label">Начальная дата:</label>
                <input type="date" class="form-control" id="startDateFilter" name="start_date">
            </div>
            <div class="col-md-6">
                <label for="endDateFilter" class="form-label">Конечная дата:</label>
                <input type="date" class="form-control" id="endDateFilter" name="end_date">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="statusFilter" class="form-label">Фильтр по статусу:</label>
                <select class="form-select" id="statusFilter" name="status">
                    <option selected disabled>Выберите статус</option>
                    @foreach ($orderstatuses as $orderstatus)
                        <option value="{{ $orderstatus->id }}">{{ $orderstatus->titlestatus }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="orderNumberFilter" class="form-label">Номер заказа:</label>
                <input type="text" class="form-control" id="orderNumberFilter" name="order_id"
                    placeholder="Введите номер заказа">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Применить фильтр</button>
        <a href="/manager/orders" class="btn btn-secondary">Сбросить фильтр</a>
    </form>

    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Номер заказа</th>
                    <th scope="col">Услуга</th>
                    <th scope="col">Дополнительная услуга</th>
                    <th scope="col">Площадь</th>
                    <th scope="col">Стоимость руб</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата заказа</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><button type="button" class="border-0 bg-white"data-bs-toggle="modal"
                                data-bs-target="#modalinfo{{ $order->id }}"><i
                                    class='bx bxs-info-square bx-md'></i></button></td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_service->titleservice }}</td>
                        <td>
                            @foreach ($order->additionalServices as $additionalService)
                                {{ $additionalService->titleadditionalservices }}
                            @endforeach
                        </td>
                        <td>{{ $order->square }}</td>
                        <td>{{ $order->cost }} руб</td>
                        <td>{{ $order->order_orderstatus->titlestatus }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->start_time)->format('d-m-y H:i') }}</td>
                        <td>
                            @if ($order->status == 1)
                                <div class="d-flex gap-2">
                                    <form action="{{ route('orders.accept', $order->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Принять</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#denyModal{{ $order->id }}">Отклонить</button>
                                </div>
                            @elseif ($order->status == 2)
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('orders.done', $order->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Выполнено</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#denyModal{{ $order->id }}">Отклонить</button>
                                    <a href="{{ route('orders.download', $order->id) }}" class="text-success">
                                        <i class='bx bxs-download bx-md'></i>
                                    </a>
                                </div>
                            @elseif ($order->status == 5)
                                <a href="{{ route('orders.download', $order->id) }}" class="text-success">
                                    <i class='bx bxs-download bx-md'></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Заявки отсутствуют</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@foreach ($orders as $order)
    <div class="modal fade" id="denyModal{{ $order->id }}" tabindex="-1"
        aria-labelledby="denyModalLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="denyModalLabel-{{ $order->id }}">Причина отказа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="denyForm-{{ $order->id }}" action="{{ route('orders.deny', $order->id) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reason" class="form-label">Причина отказа</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Отклонить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@foreach ($orders as $order)
    <div class="modal fade" id="modalinfo{{ $order->id }}" tabindex="-1"
        aria-labelledby="modalinfoLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalinfoLabel-{{ $order->id }}">Информация о заказе</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-6 fw-normal m-2">Номер заказа: {{ $order->id }}</p>
                    <p class="fs-6 fw-normal m-2">ФИО:
                        @if ($order->order_user)
                            {{ $order->order_user->name }}
                            {{ $order->order_user->lastname }}
                        @else
                            {{ $order->name }}
                        @endif
                    </p>
                    <p class="fs-6 fw-normal m-2">Почта:
                        @if ($order->order_user)
                            {{ $order->order_user->email }}
                        @else
                            {{ $order->email }}
                        @endif
                    </p>
                    <p class="fs-6 fw-normal m-2">Номер телефона: {{ $order->phone }}</p>
                    <p class="fs-6 fw-normal m-2">Адрес: {{ $order->address }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="/script/sidebar.js"></script>
<x-scripts></x-scripts>
</body>

</html>
