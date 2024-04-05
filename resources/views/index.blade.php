<x-header></x-header>
    <div class="container fw-normal ">
        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="d-flex flex-column gap-3 mt-5">
                    <div class="form-outline">
                        <h2 class="fw-normal text-start">Чистота без забот</h2>
                        <label class="form-label" for="size">Укажите площадь квартиры</label>
                        <input type="number" id="size" value="40" min="0" max="999" class="form-control" />
                    </div>
                    <label for="service">Выберите тип уборки</label>
                    <select class="form-select" name="" id="service">
                        <option value="100">Послестроительная уборка</option>
                        <option value="250">Генеральная уборка</option>
                        <option value="400">Поддерживающая уборка</option>
                    </select>
                    <div class="d-flex justify-content-between fs-5">
                        <span class="text-start">Цена:</span>
                        <span class="text-end fw-bold" id="result"></span>
                    </div>
                    <button type="button" class="btn btn-info text-white fw-semibold">Заказать</button>
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
        <div class="mt-4 w-75 mx-auto">
            <h2 class="text-center">О Компании</h2>
        </div>
        <div class="row w-75 mx-auto mb-4 ">
            <div class="col-md-6">
                <img src="https://terem-ermaka.ru/wp-content/uploads/0/0/d/00d12db40b95545d6968b5b2b61d0961.jpeg" class="img-fluid border rounded" alt="">
            </div>
            <div class="col-md-6">
                <p class="fw-semibold fs-5">Компания "АВИС Клининг" профессионально занимается наведением чистоты с 2009 года. Мы всегда готовы прийти на помощь и предоставить клининговые услуги любой сложности юридическим лицам и частным клиентам.</p>
                <p class="fw-semibold fs-5">Доверяя заботу о чистоте нашим специалистам, Вы можете быть уверены, что все виды работ будут выполнены с отличным качеством. </p>
            </div>
        </div>
    </div>

<x-footer></x-footer>
