<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Document</title>
    <x-links></x-links>
</head>

<body class="d-flex flex-column" style="min-height: 102vh">
    <x-alerts></x-alerts>
    <div class="background-image-container d-flex flex-column pb-3">
        <x-headerindex></x-headerindex>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="/create_order_validate" class="d-flex flex-column gap-3 mt-3 text-white"
                        method="POST">
                        @csrf
                        <div class="form-outline">
                            <h2 class="fw-normal text-start">Чистота без забот</h2>
                            <label class="form-label" for="square">Укажите площадь помещения</label>
                            <input type="number" id="size" value="30" min="30" max="999"
                                class="form-control form-control-lg" name="square" />
                            @error('square')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <select class="form-select form-control-lg" name="service" id="service">
                            @forelse($services as $service)
                                <option value="{{ $service->id }}" data-cost="{{ $service->cost }}"
                                    data-work-time="{{ $service->work_time }}">
                                    {{ $service->titleservice }}
                                </option>
                            @empty
                                <option selected value="0" data-cost="0" data-work-time="0">Услуг нету</option>
                            @endforelse
                        </select>
                        @error('service')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-outline">
                            <h3 class="fw-normal text-start">Дополнительные услуги</h3>
                            <div id="additional-services-container">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between fs-5">
                            <span class="text-start">Цена:</span>
                            <span class="text-end fw-bold" id="result"></span>
                        </div>

                        <div class="d-flex justify-content-between fs-5">
                            <span class="text-start">Минимальное время работы:</span>
                            <span id="timeresult"></span>
                        </div>

                        <div class="d-flex w-100 input-date">
                            <div class="d-flex w-100 input-date">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="date"
                                        placeholder="{{ old('date') }}" name="date"
                                        min="{{ now()->toDateString() }}" required>
                                    <label for="date">Выберите дату</label>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-floating" style="min-width:130px">
                                    <select class="form-control" id="time" name="time" required>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                    </select>
                                    <label for="time">Выберите время</label>
                                    @error('time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="hidden" id="service_work_time" name="service_work_time" value="">
                            </div>
                            <input type="hidden" id="service_work_time" name="service_work_time" value="">
                        </div>

                        <div class="d-flex gap-2">
                            <div class="form-floating w-100">
                                <input type="tel" class="form-control" id="phone"
                                    placeholder="{{ old('phone') }}" name="phone" maxlength="16" required>
                                <label for="phone" class="text-black">Номер телефона</label>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="address"
                                    placeholder="{{ old('address') }}" name="address" required>
                                <label for="address" class="text-black">Адрес</label>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if (Auth::check() && Auth::user()->role === 1)
                            <button type="submit" class="btn btn-info">Заказать</button>
                        @elseif (!Auth::check())
                            <div class="d-flex gap-2">
                                <div class="form-floating w-100">
                                    <input type="text" class="form-control" id="name" placeholder="Ваше имя"
                                        name="name" required>
                                    <label for="name" class="text-black">Ваше имя</label>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-floating w-100">
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Ваш email" name="email" required>
                                    <label for="email" class="text-black">Ваш email</label>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Заказать</button>
                        @else
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4" style="background-color:#f3f3f3">
        <h2 class="text-secondary">Как Мы Работаем</h2>
    </div>
    <div class="container mt-5 pb-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="card-info">
                    <img src="https://cleaninghousemaids.com/wp-content/uploads/2016/01/homepage-img-1.png"
                        alt="">
                    <div class="content">
                        <h3 class="text-center">Онлайн заявка</h3>
                        <p class="text-center">Выберите дату и время, когда вы хотите, чтобы мы пришли.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-info">
                    <img src="https://cleaninghousemaids.com/wp-content/uploads/2016/01/homepage-img-2.png"
                        alt="">
                    <div class="content">
                        <h3 class="text-center">Чистота</h3>
                        <p class="text-center">Лицензированные и сертифицированные работники
                            прибудут и тщательно уберут ваше жилье.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-info">
                    <img src="https://cleaninghousemaids.com/wp-content/uploads/2016/01/homepage-img-3.png"
                        alt="">
                    <div class="content">
                        <h3 class="text-center">Расслабьтесь</h3>
                        <p class="text-center">Устройтесь поудобнее, расслабьтесь и наслаждайтесь, не шевеля пальцем,
                            чтобы навести порядок в доме.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="services mb-4">
        <h2 class="text-center">Услуги</h2>
    </div>
    <div class="slider w-75 mx-auto">
        @forelse ($services as $service)
            <div class="slide-item">
                <div class="service-card border rounded-2">
                    <div class="bg-info text-white p-3">
                        <h2 class="text-center">{{ $service->titleservice }}</h2>
                        <p class="text-center fs-5">{{ $service->description }}</p>
                    </div>
                    <div class="row p-3">
                        <div class="col-lg-12">
                            <ul class="list-group">
                                @foreach ($service->additionalservices as $additionalService)
                                    <li class="list-group-item">{{ $additionalService->titleadditionalservices }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <span class="text-end mt-2">{{ $service->cost}} руб/кв.м</span>
                    </div>
                </div>
            </div>
        @empty
            <p>Услуги отсутствуют</p>
        @endforelse
    </div>
    <div class="bg-img-container-about text-white py-5 mt-5">
        <h2 class="text-center">ВАШЕ ДОВЕРИЕ И БЕЗОПАСНОСТЬ — НАШ ПРИОРИТЕТ</h2>
        <div class="container mt-4">
            <div class="row justify-content-center gap-3">
                <div class="col-md-3 text-center m-2">
                    <i class='bx bxs-time-five bx-lg' style="color:#9c9592"></i>
                    <h4>Экономим ваше время</h4>
                    <p>Уборка нашей компании, позволяет вам заняться чем-то другим кроме уборки</p>
                </div>
                <div class="col-md-3 text-center m-2">
                    <i class='bx bx-shield-plus bx-lg' style="color:#9c9592"></i>
                    <h4>Безопасность</h4>
                    <p>Мы тщательно проверяем всех наших клинеров, которые проходят проверку личности, а также личное
                        собеседование.</p>
                </div>
                <div class="col-md-3 text-center m-2">
                    <i class='bx bx-diamond bx-lg' style="color:#9c9592"></i>
                    <h4>Только лучшее качество</h4>
                    <p>Мы верим в качество нашей работы. У вас есть возможность оставить отзыв после каждой нашей
                        уборки.</p>
                </div>
                <div class="col-md-3 text-center m-2">
                    <i class='bx bx-shield-plus bx-lg' style="color:#9c9592"></i>
                    <h4>Гарантии</h4>
                    <p>Компания несет 100% материальную ответственность</p>
                </div>
                <div class="col-md-3 text-center m-2">
                    <i class='bx bx-lock-alt bx-lg' style="color:#9c9592"></i>
                    <h4>Надежность</h4>
                    <p>Мы выполняем свои обязательства в срок</p>
                </div>
                <div class="col-md-3 text-center m-2">
                    <i class='bx bx-trophy bx-lg' style="color:#9c9592"></i>
                    <h4>Профессионализм</h4>
                    <p>Наши сотрудники обладают высоким профессиональным уровнем</p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-img-container-comments text-white py-5">
        <div class="container">
            <h2 class="text-center pb-3">Отзывы</h2>
            <h2 class="text-center pb-3">Рейтинг {{ $averageRating }} на основе {{ $comment }} отзывов</h2>
            <div class="slider w-75 mx-auto">
                @forelse ($comments as $comment)
                    <div class="row mx-1">
                        <div class="col-md-12">
                            <div class="card mb-3" style="height: 150px">

                                <div class="card-body">
                                    <p class="card-text mt-0 fs-6">
                                        {{ Illuminate\Support\Str::limit($comment->description, 100) }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <small class="text-muted d-flex align-items-center gap-1"><i
                                            class='bx bxs-star'>{{ $comment->rating }}</i>
                                        {{ $comment->comments_user->name }}</small>
                                    <small class="text-muted">{{ $comment->created_at->format('d-m-y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    Отзывы отсутсвуют
                @endforelse
            </div>
            <form action="/comments_validate" method="POST" class="w-75 mx-auto mb-3">
                @csrf
                <div class="mb-3">
                    <label for="description" class="form-label">Напишите отзыв</label>
                    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Оценка</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    @error('rating')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if (Auth::check() && Auth::user()->role === 1)
                    <button type="submit" class="btn btn-info">Оставить отзыв</button>
                @elseif (!Auth::check())
                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#regModal">Оставить отзыв</button>
                @else
                @endif
            </form>

        </div>
    </div>
    <div class="container mt-5 py-2">
        <h2 class="text-center mb-4">Часто задаваемые вопросы</h2>
        <div class="accordion" id="faqAccordion">
            @foreach ($faqs as $index => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                            aria-controls="collapse{{ $index }}">
                            {{ $faq->titlefaq }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $faq->description }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="form_registration" id="form_registration">
                    <div class="form-container sign-up-container">
                        <form action="/signup_validation" class="auth_reg" method="POST">
                            @csrf
                            <h1 class="fw-bold">Создайте аккаунт</h1>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control border-info" id="surname" value=""
                                    placeholder="{{ old('surname') }}" name="surname">
                                <label for="surname">Фамилия</label>
                                @error('surname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control border-info" id="name" value=""
                                    placeholder="{{ old('name') }}" name="name">
                                <label for="name">Имя</label>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control border-info" id="lastname" value=""
                                    placeholder="{{ old('lastname') }}" name="lastname">
                                <label for="lastname">Отчество</label>
                                @error('lastname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="email" class="form-control border-info" id="email" value=""
                                    placeholder="{{ old('email') }}" name="email">
                                <label for="email">Почта</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="password" class="form-control border-info" id="password"
                                    value="" placeholder="{{ old('password') }}" name="password">
                                <label for="password">Пароль</label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="password" class="form-control border-info" id="confirm_password"
                                    value="" placeholder="{{ old('confirm_password') }}"
                                    name="confirm_password">
                                <label for="confirm_password">Повторите пароль</label>
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit"
                                class="border rounded-pill bg-info border-info text-white px-4 py-2 fs-6 fw-bold">Зарегистрироваться</button>
                        </form>
                    </div>
                    <div class="form-container sign-in-container">
                        <form action="/signin_validation" class="auth_reg" method="POST">
                            @csrf
                            <h1 class="fw-bold">Авторизируйтесь</h1>
                            <div class="form-floating w-100">
                                <input type="email" class="form-control border-info" id="email" value=""
                                    placeholder="{{ old('email') }}" name="email">
                                <label for="email">Почта</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="password" class="form-control border-info" id="password"
                                    value="" placeholder="{{ old('password') }}" name="password">
                                <label for="password">Пароль</label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit"
                                class="border rounded-pill bg-info border-info text-white px-4 py-2 fs-6 fw-bold">Авторизоваться</button>
                        </form>
                    </div>
                    <div class="overlay-container">
                        <div class="overlay">
                            <div class="overlay-panel overlay-left">
                                <h1>Вы вернулись!</h1>
                                <p>Что-бы зайти в свой аккаунт введите свою почту и пароль</p>
                                <button class="ghost border rounded-pill border-white px-4 py-1 text-white"
                                    id="signIn">Войти</button>
                            </div>
                            <div class="overlay-panel overlay-right">
                                <h1>Добро пожаловать!</h1>
                                <p>Введите свои персональные данные и присоединяйтесь к нам</p>
                                <button class="ghost border rounded-pill border-white px-4 py-1 text-white"
                                    id="signUp">Зарегистрироваться</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-scripts></x-scripts>
    <x-footer></x-footer>
    <script>
        const element_phone = document.getElementById('phone');
        const maskOptions = {
            mask: '+{7}(000)000-00-00'
        };
        const mask = IMask(element_phone, maskOptions);
    </script>
    <script>
        document.getElementById('service').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const serviceWorkTime = selectedOption.value.split('|')[1];

            document.getElementById('service_work_time').value = serviceWorkTime;
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.slider').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: true,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const timeInput = document.getElementById('time');

            dateInput.addEventListener('change', function() {
                const selectedDate = dateInput.value;
                fetch(`/api/booked-slots?date=${selectedDate}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Booked slots:', data);
                        updateAvailableTimes(data);
                    })
                    .catch(error => console.error('Error fetching booked slots:', error));
            });

            function updateAvailableTimes(bookedSlots) {
                const times = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00',
                    '17:00', '18:00'
                ];
                timeInput.innerHTML = '';

                times.forEach(time => {
                    if (!bookedSlots.includes(time)) {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        timeInput.appendChild(option);
                    }
                });
            }
        });
    </script>
