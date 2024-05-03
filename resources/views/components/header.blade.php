<nav class="navbar navbar-expand-sm mt-2">
    <div class="container">
        <a class="navbar-brand text-info fs-3 fw-semibold" href="/">Чистый Дом</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
            </ul>
            <ul class="navbar-nav gap-1">
                @guest
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#regModal">
                            Регистрация
                        </button>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a role="button" href="/profile" class="btn btn-outline-primary rounded-pill">
                            Личный кабинет
                        </a>
                    </li>
                    <li class="nav-item">
                        <a role="button" href="/signout" class="btn btn-outline-danger rounded-pill">
                            Выход
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<x-reg></x-reg>
