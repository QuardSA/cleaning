<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Акт об оказании услуг</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .details,
        .details th,
        .details td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }

        .details th {
            background-color: #f2f2f2;
        }

        .details {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary {
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Акт об оказании услуг № {{ $order->id }} от
                {{ \Carbon\Carbon::parse($order->start_time)->format('d.m.Y') }}</h1>
        </div>
        <p>Исполнитель: ООО "Чистый Дом", ИНН 7727233711, КПП 772701001, улица Ветошникова, 99, Уфа, Республика
            Башкортостан,тел. +7 (937) 321-51-40</p>
        <p>Заказчик: {{ $order->order_user->name }} {{ $order->order_user->surname }} {{ $order->order_user->lastname }}
        </p>
        {{-- <p>Основание: Договор: Основной договор</p> --}}

        <table class="details">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Работы, услуги</th>
                    <th>Кол-во</th>
                    <th>Ед.</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $mainServiceCost = $order->cost - $order->additionalServices->sum('cost');
                    $totalCost = $order->cost;
                    $additionalServicesCount = $order->additionalServices->count();
                    $totalItems = 1 + $additionalServicesCount;
                    $totalVAT = $totalCost * 0.1525;
                @endphp
                <tr>
                    <td>1</td>
                    <td>{{ $order->order_service->titleservice }}</td>
                    <td>1</td>
                    <td>шт</td>
                    <td>{{ number_format($mainServiceCost, 2, ',', ' ') }}</td>
                    <td>{{ number_format($mainServiceCost, 2, ',', ' ') }}</td>
                </tr>
                @foreach ($order->additionalServices as $index => $additionalService)
                    <tr>
                        <td>{{ $index + 2 }}</td>
                        <td>{{ $additionalService->titleadditionalservices }}</td>
                        <td>1</td>
                        <td>шт</td>
                        <td>{{ number_format($additionalService->cost, 2, ',', ' ') }}</td>
                        <td>{{ number_format($additionalService->cost, 2, ',', ' ') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p>Итого: {{ number_format($totalCost, 2, ',', ' ') }} руб.</p>
            {{-- <p>В том числе НДС: {{ number_format($totalVAT, 2, ',', ' ') }} руб.</p> --}}
        </div>
        <p>Всего наименований {{ $totalItems }}, на сумму {{ number_format($totalCost, 2, ',', ' ') }} руб.</p>


        <div class="footer">
            <p>Вышеперечисленные услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам
                оказания услуги не имеет.</p>
            <p>Исполнитель: _________________________</p>
            <p>Заказчик: _____________________________</p>
        </div>
    </div>
</body>
</html>
