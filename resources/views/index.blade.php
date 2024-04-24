<x-header></x-header>
{{-- <div class="bg-img">

</div>
<div class="container">

</div> --}}
<div class="container fw-normal ">
        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="">
                    <form action="/create_order_validate" class="d-flex flex-column gap-3 mt-3" method="POST">
                        @csrf
                        <div class="form-outline">
                            <h2 class="fw-normal text-start">Чистота без забот</h2>
                            <label class="form-label" for="square">Укажите площадь квартиры</label>
                            <input type="number" id="size" value="30" min="30" max="999" class="form-control form-control-lg" name="square"/>
                            @error('square')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <select class="form-select form-control-lg" name="service" id="service">
                            @forelse($services as $service)
                            <option value="{{$service->cost}}" >{{$service->titleservice}}</option>
                            @empty
                            <option disabled selected value="0">Услуг нету</option>
                            @endforelse
                        </select>
                        @error('service')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <div class="d-flex justify-content-between fs-5">
                            <span class="text-start">Цена:</span>
                            <span class="text-end fw-bold" id="result"></span>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="form-floating w-100">
                                <input type="date" class="form-control" id="date" placeholder="{{old('date')}}" name="date" min="{{ now()->toDateString() }}">
                                <label for="date">Выберите дату</label>
                                @error('date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="phone" placeholder="{{old('phone')}}" name="phone" maxlength="11">
                                <label for="phone">Номер телефона</label>
                                @error('phone')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-floating w-100">
                                <input type="text" class="form-control" id="adress" placeholder="{{old('adress')}}" name="address">
                                <label for="address">Адрес</label>
                                @error('address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->role === 1)
                        <button type="submit" class="btn btn-info">Заказать</button>
                        @elseif ((!Auth::check()))
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#regModal">Заказать</button>
                        @else
                        <span class="text-cemter fs-5 text-danger">Вы не можете сдлеать заказ являясь Администраторм</span>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <img src="https://imgproxy.domovenok.ru/insecure/w:1280/gravity:sm/rt:fit/q:80/dpr:1/plain/https://s3.domovenok.su/pancake-public/192e986f-f6a0-42c3-8e39-c27509404111.jpg" class="img-fluid" alt="">
            </div>
        </div>
        <div class="mt-4 w-75 mx-auto">
            <h2 class="text-center">О нас</h2>
            <p class="text-center fs-4 fw-semibold">Мы стремимся предоставить нашим клиентам наилучший сервис уборки, обеспечивая чистоту и комфорт в их домах и офисах.</p>
        </div>
        <div class="d-flex about_us">
            <div class="row mt-3 mx-auto w-75">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center">
                        <i class='bx bx-shield-plus text-info' style="font-size: 128px"></i>
                    </div>
                    <h3 class="text-center text-info">Гарантии</h3>
                    <p class="text-center fw-semibold fs-5">Компания несет 100% материальную ответственность</p>
                </div>
                <div class="col-md-6 ">
                    <div class="d-flex justify-content-center text-info">
                        <i class='bx bx-lock-alt text-info' style="font-size: 128px"></i>
                    </div>
                    <h3 class="text-center text-info">Надежность</h3>
                    <p class="text-center fw-semibold fs-5">Мы выполняем свои обязательства в срок</p>
                </div>
                <div class="col-md-6 ">
                    <div class="d-flex justify-content-center">
                        <i class='bx bx-trophy text-info' style="font-size: 128px"></i>
                    </div>
                    <h3 class="text-center text-info">Профессионализм</h3>
                    <p class="text-center fw-semibold fs-5">Наши сотрудники обладают высоким профессиональным уровнем</p>
                </div>
                <div class="col-md-6 ">
                    <div class="d-flex justify-content-center">
                        <i class='bx bxs-select-multiple text-info' style="font-size: 128px"></i>
                    </div>
                    <h3 class="text-center text-info">Качество</h3>
                    <p class="text-center fw-semibold fs-5">мы гарантируем высокое качество наших услуг</p>
                </div>
            </div>
        </div>
        <div class="services">
            <h2 class="text-center">Услуги</h2>
        </div>
        <div class="slider w-75 mx-auto">
            @forelse ($services as $service)
            <div class="row mx-1">
                <div class="col-md-12" >
                    <a href="/object/{{$service->id}}" class="text-decoration-none text-dark" style="min-height: 100%">
                        <div class="border rounded" >
                            <div class="border-bottom bg-info">
                                <h3 class="text-center fw-semibold text-white">{{$service->titleservice}}</h3>
                            </div>
                            <div class="text-center mt-3">
                                <span class="fs-5">{{ Illuminate\Support\Str::limit($service->description, 40) }}</span>
                            </div>
                            <hr class="mx-auto" style="width: 95%">
                            <ul>
                                @foreach ($service->features as $feature)
                                <li class="list-group-item d-flex align-items-center"><i class='bx bx-check text-success fs-3 me-2'></i><span class="fs-5">{{ $feature->titlefeatures }}</span></li>
                                @endforeach
                            </ul>
                            <div class="text-end my-2 me-2 ">
                                <span class="fs-5 fw-bold">от {{$service->cost}} р</span>
                            </div>
                        </div>
                    </a>
                 </div>
            </div>
            @empty
            Услуги отсутствуют
            @endforelse
        </div>
        <div class="mt-4 w-75 mx-auto">
            <h2 class="text-center">О Компании</h2>
        </div>
        <div class="row w-75 mx-auto mb-4 ">
            <div class="col-md-6">
                <img src="https://terem-ermaka.ru/wp-content/uploads/0/0/d/00d12db40b95545d6968b5b2b61d0961.jpeg" class="img-fluid border rounded" alt="">
            </div>
            <div class="col-md-6">
                <p class="fw-semibold fs-5">Компания "Чистый Дом" профессионально занимается наведением чистоты с 2009 года. Мы всегда готовы прийти на помощь и предоставить клининговые услуги любой сложности юридическим лицам и частным клиентам.</p>
                <p class="fw-semibold fs-5">Доверяя заботу о чистоте нашим специалистам, Вы можете быть уверены, что все виды работ будут выполнены с отличным качеством. </p>
            </div>
        </div>

        <h2 class="text-center mb-4">Отзывы наших клиентов</h2>
        <div class="slider w-75 mx-auto">
            @forelse ($comments as $comment)
                <div class="row mx-1">
                    <div class="col-md-12">
                      <div class="card mb-3">
                        <div class="card-body">
                          <p class="card-text mt-0 fs-6">{{Illuminate\Support\Str::limit($comment->description, 100)}}</p>
                        </div>
                        <div class="card-footer">
                          <small class="text-muted">{{$comment->comments_user->name}} {{$comment->comments_user->surname}}</small>
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
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            @if (Auth::check() && Auth::user()->role === 1)
            <button type="submit" class="btn btn-info">Оставить отзыв</button>
            @elseif ((!Auth::check()))
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#regModal">Оставить отзыв</button>
            @else
            <span class="text-cemter fs-5 text-danger">Вы не можете оставить отзыв являясь Администраторм</span>
            @endif
        </form>
    </div>

<x-footer></x-footer>
