<x-header></x-header>
<div class="container mt-2 fst-normal">
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="d-flex flex-column gap-3 mt-5">
                <div class="form-outline">
                    <h2 class="fw-normal text-start">Поддерживающая уборка</h2>
                    <label class="form-label" for="size">Укажите площадь квартиры</label>
                    <input type="number" id="size" value="10" min="10" max="999" class="form-control" />
                </div>
                <select class="form-select" name="" id="service">
                    <option value="400">Поддерживающая уборка</option>
                </select>
                <div class="d-flex justify-content-between fs-5">
                    <span class="text-start">Цена:</span>
                    <span class="text-end fw-bold" id="result"></span>
                </div>
                <button type="button" class="btn btn-info">Заказать</button>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <img src="https://imgproxy.domovenok.ru/insecure/w:1280/gravity:sm/rt:fit/q:80/dpr:1/plain/https://s3.domovenok.su/pancake-public/192e986f-f6a0-42c3-8e39-c27509404111.jpg" class="img-fluid" alt="">
        </div>
    </div>
    <h3 class="mt-2">Описание</h3>
    <div class="description">
        <p class="text-start fs-5 fw">Клининговая услуга предусматривает устранение загрязнений на высоту до 180 см и включает более 20 работ. На поддерживающую уборку квартир цена зависит от размеров помещения, наличия дополнительных пожеланий. Для клиентов с регулярным графиком обслуживания действуют скидки.</p>
    </div>
    <div class="mt-4 w-75 mx-auto">
        <h2 class="text-center">Преимущества клинингового сервиса "Домовёнок"</h2>
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
    <div class="slider w-75 mx-auto">
        <div class="row mx-1">
            <a href="/object" class="text-decoration-none text-dark">
                <div class="col-md-12">
                    <div class="border rounded">
                        <div class="border-bottom bg-info">
                            <h3 class="text-center fw-semibold text-white">Поддерживающая уборка</h3>
                        </div>
                        <div class="text-center mt-3">
                            <span class="fs-5">Стандартный клининг всей квартиры</span>
                        </div>
                        <hr class="mx-auto" style="width: 95%">
                        <ul class="">
                            <li class="list-group-item d-flex align-items-center"><i class='bx bx-check text-success fs-3 me-2'></i><span class="fs-5">1-2 исполнителя</span></li>
                            <li class="list-group-item d-flex align-items-center"><i class='bx bx-check text-success fs-3 me-2'></i><span class="fs-5">Удаляются легкие загрязнения</span></li>
                            <li class="list-group-item d-flex align-items-center"><i class='bx bx-check text-success fs-3 me-2'></i><span class="fs-5">Уборка до 1,8 метров</span></li>
                            <li class="list-group-item d-flex align-items-center"><i class='bx bx-check text-success fs-3 me-2'></i><span class="fs-5">Работа 2-5 часов</span></li>
                        </ul>
                        <div class="text-end my-2 me-2 ">
                            <span class="fs-5 fw-bold">от 500р</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<x-footer></x-footer>
