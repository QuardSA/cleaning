<div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
            <div class="form_registration" id="form_registration">
                <div class="form-container sign-up-container">
                    <form action="/signup_validation" class="auth_reg" method="POST">
                        @csrf
                        <h1 class="fw-bold">Создайте аккаунт</h1>
                        <div class="form-floating w-100">
                            <input type="text" class="form-control border-info" id="name" value="" placeholder="{{old('name')}}" name="name">
                            <label for="name">Ваше имя</label>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="text" class="form-control border-info" id="surname" value="" placeholder="{{old('surname')}}" name="surname">
                            <label for="surname">Фамилия</label>
                            @error('surname')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="text" class="form-control border-info" id="lastname" value="" placeholder="{{old('lastname')}}" name="lastname">
                            <label for="lastname">Отчество</label>
                            @error('lastname')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="email" class="form-control border-info" id="email" value="" placeholder="{{old('email')}}" name="email">
                            <label for="email">Почта</label>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="password" class="form-control border-info" id="password" value="" placeholder="{{old('password')}}" name="password">
                            <label for="password">Пароль</label>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="password" class="form-control border-info" id="confirm_password" value="" placeholder="{{old('confirm_password')}}" name="confirm_password">
                            <label for="confirm_password">Повторите пароль</label>
                            @error('confirm_password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <button type="submit" class="border rounded-pill bg-info border-info text-white px-4 py-2 fs-6 fw-bold">Зарегистрироваться</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form action="/signin_validation" class="auth_reg" method="POST">
                        @csrf
                        <h1 class="fw-bold">Авторизируйтесь</h1>
                        <div class="form-floating w-100">
                            <input type="email" class="form-control border-info" id="email" value="" placeholder="{{old('email')}}" name="email">
                            <label for="email">Почта</label>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="password" class="form-control border-info" id="password" value="" placeholder="{{old('password')}}" name="password">
                            <label for="password">Пароль</label>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                        <button type="submit" class="border rounded-pill bg-info border-info text-white px-4 py-2 fs-6 fw-bold">Авторизоваться</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Вы вернулись!</h1>
                            <p>Что-бы зайти в свой аккаунт введите свою почту и пароль</p>
                            <button class="ghost border rounded-pill border-white px-4 py-1 text-white" id="signIn">Войти</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Добро пожаловать!</h1>
                            <p>Введите свои персональные данные и присоединяйтесь к нам</p>
                            <button class="ghost border rounded-pill border-white px-4 py-1 text-white" id="signUp">Зарегистрироваться</button>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>

