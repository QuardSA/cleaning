<x-header></x-header>
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="card">
                    <div class="card-header">
                        Меню
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="/personal" class="text-decoration-none text-dark">Мои заказы</a>
                        </li>
                        <li class="list-group-item">
                            <a href="/profile" class="text-decoration-none text-dark">Настройки профиля</a>
                        </li>
                        <li class="list-group-item">
                            <a href="/signout" class="text-decoration-none text-dark">Выйти</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 mt-2">
                <div class="card">
                    <div class="card-header">
                        Мой профиль
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="firstName" class="form-label">Имя</label>
                                <input type="text" class="form-control" id="firstName" value="">
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Фамилия</label>
                                <input type="text" class="form-control" id="lastName" value="">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email адрес</label>
                                <input type="email" class="form-control" id="email" value="">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Номер телефона</label>
                                <input type="text" class="form-control" id="phone" value="">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес</label>
                                <textarea class="form-control" id="address" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<x-footer></x-footer>
