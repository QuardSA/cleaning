<x-header></x-header>
<div class="container">
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
                <div class="card-body">
                    <div class="card border-info">
                        <div class="card-header border-info bg-white fw-semibold">
                            Заказ #12345
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Дата заказа:</strong> 2024-03-30</li>
                                <li class="list-group-item"><strong>Услуга:</strong> Генеральная уборка</li>
                                <li class="list-group-item"><strong>Адрес:</strong> ул. Пушкина, дом Колотушкина</li>
                                <li class="list-group-item"><strong>Статус:</strong> Выполнен</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer></x-footer>
