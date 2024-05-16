<x-admin.header></x-admin.header>
<div class="container mt-5">
    <h2 class="text-center mb-4">Заявки</h2>
    <form action="/admin/orders" method="GET">
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="dateFilter" class="form-label">Фильтр по дате:</label>
                <input type="date" class="form-control" id="dateFilter" name="date">
            </div>
            <div class="col-md-6">
                <label for="statusFilter" class="form-label">Фильтр по статусу:</label>
                <select class="form-select" id="statusFilter" name="status">
                    <option selected disabled>Выберите статус</option>
                    @foreach ($orderstatuses as $orderstatus)
                        <option value="{{ $orderstatus->id }}">{{ $orderstatus->titlestatus }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Применить фильтр</button>
        <a href="/admin/orders" class="btn btn-secondary">Сбросить фильтр</a>
    </form>
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">ФИО</th>
                <th scope="col">E-mail</th>
                <th scope="col">Номер телефона</th>
                <th scope="col">Услуга</th>
                <th scope="col">Площадь</th>
                <th scope="col">Цена</th>
                <th scope="col">Адрес</th>
                <th scope="col">Статус</th>
                <th scope="col">Дата заказа</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->order_user->name }} {{ $order->order_user->surname }}
                        {{ $order->order_user->lastname }}</td>
                    <td>{{ $order->order_user->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->order_service->titleservice }}</td>
                    <td>{{ $order->square }}</td>
                    <td>{{ $order->cost }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->order_orderstatus->titlestatus }}</td>
                    <td>{{ $order->start_time }}</td>
                    <td>
                        @if ($order->status == 1)
                            <div class="d-flex gap-2">
                                <form action="{{ route('orders.accept', $order->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Принять</button>
                                </form>
                                <form action="{{ route('orders.deny', $order->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Отклонить</button>
                                </form>
                            </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="/script/sidebar.js"></script>
</body>

</html>
