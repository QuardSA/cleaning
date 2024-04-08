<x-admin.header></x-admin.header>
<div class="container mt-5">
    <h2 class="text-center mb-4">Заявки</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="dateFilter" class="form-label">Фильтр по дате:</label>
            <input type="date" class="form-control" id="dateFilter">
        </div>
        <div class="col-md-6">
            <label for="statusFilter" class="form-label">Фильтр по статусу:</label>
            <select class="form-select" id="statusFilter">
                <option selected>Выбрать статус...</option>
                <option>Ождание</option>
                <option>Принято</option>
                <option>Выполнено</option>
                <option>Отклонено</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">E-mail</th>
                <th scope="col">Номер телефона</th>
                <th scope="col">Услуга</th>
                <th scope="col">Площадь</th>
                <th scope="col">Цена</th>
                <th scope="col">Адрес</th>
                <th scope="col">Статус</th>
                <th scope="col">Дата заказа</th>
                <th scope="col">Действия</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>ФИО</td>
                <td>E-mail</td>
                <td>Номер телефона</td>
                <td>Услуга</td>
                <td>Площадь</td>
                <td>Цена</td>
                <td>Адрес</td>
                <td>Статус</td>
                <td>Дата заказа</td>
                <td>
                    <button type="button" class="btn btn-primary">Статус</button>
                    <button type="button" class="btn btn-danger">Отклонить</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="/script/sidebar.js"></script>
</body>
</html>
