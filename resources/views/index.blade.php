<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-links></x-links>
    <title>Document</title>
</head>

<body class="d-flex flex-column" style="min-height: 102vh">
    <x-alerts></x-alerts>
    <div class="background-image-container d-flex flex-column pb-3">
        <x-header></x-header>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="/create_order_validate" class="d-flex flex-column gap-3 mt-3 text-white"
                        method="POST">
                        @csrf
                        <div class="form-outline">
                            <h2 class="fw-normal text-start">Чистота без забот</h2>
                            <label class="form-label" for="square">Укажите площадь квартиры</label>
                            <input type="number" id="size" value="30" min="30" max="999"
                                class="form-control form-control-lg" name="square" />
                            @error('square')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <select class="form-select form-control-lg" name="service" id="service">
                            @forelse($services as $service)
                                <option value="{{ $service->cost }}|{{ $service->work_time }}">{{ $service->titleservice }}</option>
                            @empty
                                <option selected value="0 | 0">Услуг нету</option>
                            @endforelse
                        </select>
                        @error('service')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="d-flex justify-content-between fs-5">
                            <span class="text-start">Цена:</span>
                            <span class="text-end fw-bold" id="result"></span>
                        </div>

                        <div class="d-flex justify-content-between fs-5">
                            <span class="text-start">Минимальное время работы:</span>
                            <span id="timeresult"></span>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-floating w-100">
                                <input type="date" class="form-control" id="date"
                                    placeholder="{{ old('date') }}" name="date" min="{{ now()->toDateString() }}">
                                <label for="date">Выберите дату</label>
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="tel" class="form-control" id="phone"
                                    placeholder="{{ old('phone') }}" name="phone" maxlength="11">
                                <label for="phone" class="text-black">Номер телефона</label>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="adress"
                                    placeholder="{{ old('adress') }}" name="address">
                                <label for="address" class="text-black">Адрес</label>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->role === 1)
                            <button type="submit" class="btn btn-info">Заказать</button>
                        @elseif (!Auth::check())
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#regModal">Заказать</button>
                        @else
                            <span class="text-cemter fs-5 text-danger">Вы не можете сдлеать заказ являясь
                                Администраторм</span>
                        @endif
                    </form>
                </div>
                {{-- <div class="col-md-6 mt-2">
                    <img src="/img/cleaner2.png" class="img-fluid" alt="">
                </div> --}}
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
                        <p class="text-center">Лицензированные, связанные, застрахованные и сертифицированные горничные
                            прибудут и тщательно уберут ваше жилье.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-info">
                    <img src="https://cleaninghousemaids.com/wp-content/uploads/2016/01/homepage-img-3.png"
                        alt="">
                    <div class="content">
                        <h3 class="text-center">Расслабтесь</h3>
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
            <div class="row mx-1">
                <div class="col-md-12">
                    <a href="/object/{{ $service->id }}" class="text-decoration-none text-dark"
                        style="min-height: 100%">
                        <div class="border rounded" style="height: 400px">
                            <div class="border-bottom bg-info">
                                <h3 class="text-center fw-semibold text-white">{{ $service->titleservice }}</h3>
                            </div>
                            <div class="text-center mt-3">
                                <span
                                    class="fs-5">{{ Illuminate\Support\Str::limit($service->description, 40) }}</span>
                            </div>
                            <hr class="mx-auto" style="width: 95%">
                            <ul>
                                @foreach ($service->features as $feature)
                                    <li class="list-group-item d-flex align-items-center"><i
                                            class='bx bx-check text-success fs-3 me-2'></i><span
                                            class="fs-5">{{ $feature->titlefeatures }}</span></li>
                                @endforeach
                            </ul>
                            <div class="text-end my-2 me-2 ">
                                <span class="fs-5 fw-bold">от {{ $service->cost }} р</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            Услуги отсутствуют
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
            <div class="slider w-75 mx-auto">
                @forelse ($comments as $comment)
                    <div class="row mx-1">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <p class="card-text mt-0 fs-6">
                                        {{ Illuminate\Support\Str::limit($comment->description, 100) }}</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">{{ $comment->comments_user->name }}
                                        {{ $comment->comments_user->surname }}</small>
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
                @if (Auth::check() && Auth::user()->role === 1)
                    <button type="submit" class="btn btn-info">Оставить отзыв</button>
                @elseif (!Auth::check())
                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#regModal">Оставить
                        отзыв</button>
                @else
                    <span class="text-cemter fs-5 text-danger">Вы не можете оставить отзыв являясь
                        Администраторм</span>
                @endif
            </form>
        </div>
    </div>
    <div class="container mt-5 py-2">
        <h2 class="text-center mb-4">Часто задаваемые вопросы</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        В чем преимущество использования услуг горничных по уборке дома
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Служба уборки дома экономит ваше драгоценное время, выполняя уборку, позволяя вам
                        сосредоточиться на других задачах и занятиях.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
