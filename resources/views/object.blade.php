<x-header></x-header>
<div class="container mt-2 fst-normal">
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="">
                <form action="/create_order_validate" class="d-flex flex-column gap-3 mt-5" method="POST">
                    @csrf
                    <div class="form-outline">
                        <h2 class="fw-normal text-start">{{$service->titleservice}}</h2>
                        <label class="form-label" for="size">Укажите площадь квартиры</label>
                        <input type="number" id="size" value="30" min="10" max="999" class="form-control" name="square"/>
                    </div>
                    <select class="form-select" name="service" id="service">
                        <option value="{{$service->cost}}" selected>{{$service->titleservice}}</option>
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
                            <input type="date" class="form-control" id="date" value="" placeholder="{{old('date')}}" name="date">
                            <label for="date">Выберите дату</label>
                            @error('date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="text" class="form-control" id="phone" value="" placeholder="{{old('phone')}}" name="phone">
                            <label for="phone">Номер телефона</label>
                            @error('phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-floating w-100">
                            <input type="text" class="form-control" id="adress" value="" placeholder="{{old('adress')}}" name="address">
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
            <img src="/storage/images/{{$service->photo}}" class="img-fluid" alt="">
        </div>
    </div>
    <h3 class="mt-2">Описание</h3>
    <div class="description">
        <p class="text-start fs-5 fw">{{$service->description}}</p>
    </div>
    <div class="mt-4 w-75 mx-auto">
        <h2 class="text-center">Преимущества клинингового сервиса "Чистый Дом"</h2>
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
    <h2 class="mt-2 text-center">Другие наши услуги</h2>
    <div class="slider w-75 mx-auto mb-3">
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
</div>

<x-footer></x-footer>
