
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<x-admin.header></x-admin.header>
<body>
    <div class="container mt-5">
        <h2 class="text-start">Панель администратора</h2>
        <div class="row mt-3 gap-1">
            <div class="rounded col  bg-success bg-gradient px-0" style="">
                <div class="inner px-2">
                    <h3 class="text-white fw-semibold mt-2">{{ $users }}</h3>
                    <p class="text-white fs-5 mt-0 fw-semibold">Менеджеры</p>
                </div>
                <a href="/admin/users"
                    class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                    <span class="d-inline-block">Больше</span>
                    <i class='bx bxs-right-arrow-circle'></i>
                </a>
            </div>
            <div class="rounded col  bg-warning bg-gradient px-0" style="">
                <div class="inner px-2">
                    <h3 class="text-white fw-semibold mt-2">{{ $services }}</h3>
                    <p class="text-white fs-5 mt-0 fw-semibold">Все услуги</p>
                </div>
                <a href="/admin/service"
                    class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                    <span class="d-inline-block">Больше</span>
                    <i class='bx bxs-right-arrow-circle'></i>
                </a>
            </div>
            <div class="rounded col  bg-primary bg-gradient px-0" style="">
                <div class="inner px-2">
                    <h3 class="text-white fw-semibold mt-2">{{ $additionalservices }}</h3>
                    <p class="text-white fs-5 mt-0 fw-semibold">Доп.услуги</p>
                </div>
                <a href="/admin/additional_service"
                    class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                    <span class="d-inline-block">Больше</span>
                    <i class='bx bxs-right-arrow-circle'></i>
                </a>
            </div>
            <div class="rounded col bg-secondary bg-gradient px-0" style="max-width: 310px">
                <div class="inner px-2">
                    <h3 class="text-white fw-semibold mt-2">{{ $faqs }}</h3>
                    <p class="text-white fs-5 mt-0 fw-semibold">FAQ</p>
                </div>
                <a href="/admin/faq"
                    class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                    <span class="d-inline-block">Больше</span>
                    <i class='bx bxs-right-arrow-circle'></i>
                </a>
            </div>
            <div class="rounded col  bg-danger bg-gradient px-0" style="">
                <div class="inner px-2">
                    <h3 class="text-white fw-semibold mt-2 p-1 mb-5">Логи</h3>
                </div>
                <a href="/admin/logs"
                    class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                    <span class="d-inline-block">Больше</span>
                    <i class='bx bxs-right-arrow-circle'></i>
                </a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="order_chart border-none shadow rounded p-3">
                    <h3 class="text-center">Продажи</h3>
                    <canvas id="lineChart"></canvas>
                    <form class="d-flex gap-2 mt-1" method="POST" id="filterForm">
                        @csrf
                        <select class="form-select" id="selectMonth">
                            @if ($uniqueMonths->isNotEmpty())
                                @foreach ($uniqueMonths as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            @else
                                <option selected disabled>Нет доступных месяцев</option>
                            @endif
                        </select>
                        <select class="form-select" id="selectYear">
                            @if ($uniqueYears->isNotEmpty())
                                @foreach ($uniqueYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            @else
                                <option selected disabled>Нет доступных годов</option>
                            @endif
                        </select>
                        <button type="button" class="btn btn-success">Применить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/script/sidebar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectMonth = document.getElementById('selectMonth');
            const selectYear = document.getElementById('selectYear');
            const applyButton = document.querySelector('.btn-success');
            const lineChartCanvas = document.getElementById('lineChart');

            if (lineChartCanvas) {
                var ctx = document.getElementById('lineChart').getContext('2d');
                var lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! $labels !!},
                        datasets: [{
                            label: 'Общая сумма продаж',
                            data: {!! $data !!},
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            function updateChart(labels, data) {
                lineChart.data.labels = labels;
                lineChart.data.datasets[0].data = data;
                lineChart.update();
            }

            if (applyButton) {
                applyButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    const selectedMonth = selectMonth.value;
                    const selectedYear = selectYear.value;

                    fetch('{{ route('admin.filter') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                month: selectedMonth,
                                year: selectedYear
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            updateChart(data.labels, data.data);
                        })
                        .catch(error => console.error('Ошибка:', error));
                });
            }
        });
    </script>
</body>

</html>
