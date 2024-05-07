<x-admin.header></x-admin.header>

<div class="container mt-5">
    <h1 class="mb-4">Логи действий пользователей</h1>
    <form action="" method="get">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="user_id">Пользователь</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Все пользователи</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }} {{ $user->surname }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="role_id">Роль</label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Все роли</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if(request('role_id') == $role->id) selected @endif>{{ $role->titlerole }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="action">Действие</label>
                    <select name="action" id="action" class="form-control">
                        <option value="">Все действия</option>
                        <option value="Оставление отзыва" @if(request('action') == 'Оставление отзыва') selected @endif>Оставление отзыва</option>
                        <option value="Создание заказа" @if(request('action') == 'Создание заказа') selected @endif>Создание заказа</option>
                        <option value="Изменение профиля" @if(request('action') == 'Изменение профиля') selected @endif>Изменение профиля</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Применить фильтр</button>
    </form>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Email</th>
                    <th scope="col">Роль</th>
                    <th scope="col">IP-адрес</th>
                    <th scope="col">Действие</th>
                    <th scope="col">Дата и время</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredLogs as $log)
                    <tr>
                        <td>{{ $log['user_id'] ?? '' }}</td>
                        <td>{{ $log['user_surname'] }} {{ $log['user_name'] }} {{ $log['user_lastname'] }}</td>
                        <td>{{ $log['user_email'] }}</td>
                        <td>{{ $log['user_role'] ?? '' }}</td>
                        <td>{{ $log['ip_address'] }}</td>
                        <td>{{ $log['action'] }}</td>
                        <td>{{ $log['date_time'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




{{-- <div class="container">
    <h1>Логи аутентификации</h1>
    <ul>
        @foreach ($filteredLogs as $log)
            <li>{{ $log }}</li>
        @endforeach
    </ul>
</div> --}}








<script src="/script/sidebar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
