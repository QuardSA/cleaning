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
                            <option value="{{ $user->id }}" @if (request('user_id') == $user->id) selected @endif>
                                {{ $user->name }} {{ $user->surname }} {{ $user->lastname }}</option>
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
                            <option value="{{ $role->id }}" @if (request('role_id') == $role->id) selected @endif>
                                {{ $role->titlerole }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="action">Действие</label>
                    <select name="action" id="action" class="form-control">
                        <option value="">Все действия</option>
                        <option value="Оставление отзыва" @if (request('action') == 'Оставление отзыва') selected @endif>Оставление
                            отзыва</option>
                        <option value="Создание заказа" @if (request('action') == 'Создание заказа') selected @endif>Создание
                            заказа</option>
                        <option value="Изменение профиля" @if (request('action') == 'Изменение профиля') selected @endif>Изменение
                            профиля</option>
                        <option value="Выход из системы" @if (request('action') == 'Выход из системы') selected @endif>Выход из
                            системы</option>
                        <option value="Регистрация" @if (request('action') == 'Регистрация') selected @endif>Регистрация
                        </option>
                        <option value="Вход в систему" @if (request('action') == 'Вход в систему') selected @endif>Вход в систему
                        </option>
                        <option value="Редактирование услуги" @if (request('action') == 'Редактирование услуги') selected @endif>
                            Редактирование услуги</option>
                        <option value="Создание услуги" @if (request('action') == 'Создание услуги') selected @endif>Создание
                            услуги</option>
                        <option value="Удаление услуги" @if (request('action') == 'Удаление услуги') selected @endif>Удаление
                            услуги</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Применить фильтр</button>
        <a href="/admin/logs" class="btn btn-secondary mt-2">Сбросить фильтр</a>
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
                @foreach ($paginatedLogs as $log)
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
    {{ $paginatedLogs->withQueryString()->links('pagination::bootstrap-5') }}
</div>
<script src="/script/sidebar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
