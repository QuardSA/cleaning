

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
            <div class="col-md-8 mt-2 mb-4">
                <div class="card border-info">
                    <div class="card-header border-info bg-white fw-semibold">
                        Мой профиль
                    </div>
                    <div class="card-body">
                        <form action="/update_profile" method="POST">
                            @csrf
                            <div class="form-floating mt-2">
                                <input type="text" class="form-control border-info" id="name"
                                    value="{{ Auth::user()->name }}" placeholder="" name="name">
                                <label for="name">Имя</label>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <input type="text" class="form-control border-info" id="surname"
                                    value="{{ Auth::user()->surname }}" placeholder="" name="surname">
                                <label for="surname">Фамилия</label>
                                @error('surname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <input type="text" class="form-control border-info" id="lastname"
                                    value="{{ Auth::user()->lastname }}" placeholder="" name="lastname">
                                <label for="lastname">Отчество</label>
                                @error('lastname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <input type="email" class="form-control border-info" id="email"
                                    value="{{ Auth::user()->email }}" placeholder="" name="email">
                                <label for="email">Почта</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-floating mt-2">
                                <input type="password" class="form-control border-info" id="current_password"
                                    placeholder="" name="current_password">
                                <label for="current_password">Текущий пароль</label>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <input type="password" class="form-control border-info" id="new_password" placeholder=""
                                    name="new_password">
                                <label for="new_password">Новый пароль</label>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mt-2">
                                <input type="password" class="form-control border-info" id="new_password_confirmation"
                                    placeholder="" name="new_password_confirmation">
                                <label for="new_password_confirmation">Подтверждение нового пароля</label>
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-info mt-2 text-white">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</html>
