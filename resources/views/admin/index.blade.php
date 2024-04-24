<x-admin.header></x-admin.header>

<div class="container mt-5">
    <h2 class="text-start">Панель администратора</h2>
    <div class="row gap-2 mt-3 justify-content-center">
        <div class="rounded col-lg-3 col-6 bg-primary bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">150</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Новые заявки</p>
            </div>
            <a href="#"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
        <div class="rounded col-lg-3 col-6 bg-success bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">44</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Пользователи</p>
            </div>
            <a href="#"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
        <div class="rounded col-lg-3 col-6 bg-warning bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">14</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Все услуги</p>
            </div>
            <a href="#"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
        <div class="rounded col-lg-3 col-6 bg-danger bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">189</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Логи</p>
            </div>
            <a href="#"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6">
            <div class="order_chart border-none shadow rounded p-3">
                <h3>Продажи</h3>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="order_chart border-none shadow rounded p-3">
                <h3>Продажи</h3>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="/script/sidebar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/script/chart.js"></script>
</body>

</html>
