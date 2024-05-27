<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Договор №5 возмездного оказания услуг</title>
</head>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        line-height: 1.0;
        margin: 20px;
        color: #000;
    }

    .contract {
        width: 100%;
        margin: auto;
        padding: 10px;
        box-shadow: 0px 0px 10px 0px #000;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .contract-number {
        font-weight: bold;
        font-size: 18px;
    }

    .contract-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .contract-date {
        margin-bottom: 20px;
    }

    h2 {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    p {
        text-indent: 30px;
    }

    .signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .customer,
    .executor {
        width: 45%;
    }

    .sign-dates {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .sign-dates .left,
    .sign-dates .right {
        width: 45%;
    }
</style>

<body>
    <div class="contract">
        <div class="header">
            <div class="contract-number">ДОГОВОР №{{ $order->id }}</div>
            <div class="contract-title">возмездного оказания услуг</div>
            <div class="contract-date">г.Уфа<br>{{ \Carbon\Carbon::parse($order->updated_at)->format('d.m.Y') }}</div>
        </div>
        @php
            $mainServiceCost = $order->cost - $order->additionalServices->sum('cost');
            $totalCost = $order->cost;
            $additionalServicesCount = $order->additionalServices->count();
            $totalItems = 1 + $additionalServicesCount;
            $totalVAT = $totalCost * 0.1525;
        @endphp
        <p>Общество с ограниченной ответственностью "Чистый дом" в лице Директора Смирнова А.А, действующего на
            основании Устава, именуемый в дальнейшем "Исполнитель", с одной стороны, и
            гражданин @if ($order->order_user)
                {{ $order->order_user->name }} {{ $order->order_user->surname }} {{ $order->order_user->lastname }}
            @else
                {{ $order->name }} {{ $order->surname ?? '' }}
                @endif, именуемый(ая) в дальнейшем "Заказчик", с другой стороны, являющиеся
                сторонами договора, заключили настоящий трудовой договор о нижеследующем:</p>

        <h2>1. Предмет договора</h2>
        <p>1.1. Исполнитель обязуется по заданию Заказчика оказать следующие услуги:
            {{ $order->order_service->titleservice }},@foreach ($order->additionalServices as $index => $additionalService)
                {{ $additionalService->titleadditionalservices }}
            @endforeach.</p>

        <h2>2. Права и обязанности сторон</h2>
        <p>2.1. Исполнитель обязан оказать услуги в полном объёме с надлежащим качеством.</p>
        <p>2.2. Заказчик вправе отказать в принятии услуг, оказанных с ненадлежащим качеством, в течение 1 дня.</p>
        <p>2.3. Исполнитель вправе оказать услугу досрочно, а Заказчик принять работы до истечения предусмотренного
            срока.</p>
        <p>2.4. Заказчик обязан оплатить услуги.</p>
        <p>2.5. Заказчик вправе проверять процесс хода и качество работы, выполняемой Исполнителем, не вмешиваясь в его
            деятельность.</p>
        <p>2.6. Заказчик имеет право отказаться от исполнения договора в любое время до завершения выполнения
            Исполнителем части услуги с обязательной оплатой уже оказанных услуг.</p>

        <h2>3. Стоимость услуг и расчеты сторон</h2>
        <p>3.1. Общая стоимость услуг Заказчика по настоящему договору составляет
            {{ number_format($totalCost, 2, ',', ' ') }} руб., стоимость услуг.
        </p>
        <p>3.2. Оплата производится единовременно в конце оказания услуг.</p>
        <p>3.3. При оплате с Заказчика производятся все установленные законодательством РФ начисления и удержания, в
            том числе НДФЛ.</p>

        <h2>4. Сдача-приёмка оказанных услуг</h2>
        <p>4.1. Фактом, подтверждающим предоставление услуг Исполнителя Заказчику является подписанный сторонами акт
            об оказании услуг.</p>

        <h2>5. Прочие условия</h2>
        <p>5.1. Стороны вправе досрочно прекратить свои отношения по настоящему договору, предупредив за два дня о
            предстоящей дате расторжения договора.</p>
        <p>5.2. Заказчик вправе отказаться от исполнения настоящего договора при условии полной оплаты Исполнителю
            фактически понесенных им расходов.</p>
        <p>5.3. Исполнитель вправе отказаться от исполнения настоящего договора при условии полного возмещения Заказчику
            убытков.</p>
        <p>5.4. К настоящему договору применяются общие положения о подряде (ст.702-729 ГК РФ), если иное не
            противоречит ст.779-782 ГК РФ, регулирующим договор возмездного оказания услуг.</p>
        <p>5.5. Договор составлен в 2-х экземплярах, имеющих одинаковую юридическую силу, по одному экземпляру для
            каждой из сторон.</p>

        <h2>6. Адреса и подписи сторон</h2>
        <div class="signatures">
            <div class="customer">
                <strong>Исполнитель:</strong><br>
                ООО "Чистый дом"<br>
                Адрес: г.Уфа Ветошникова, 99 п.6<br>
                Телефон: +7 (937) 321-51-40<br>
                КПП 772701001
                <br>
                ИНН 7727233711,
                <br>
                <strong>Смирнов А.А /__________</strong><br>
                <strong>ФИО</strong>
            </div>
            <br>
            <div class="executor">
                <strong>Заказчик:</strong><br>
                Адресс: {{ $order->address }}<br>
                Телефон: {{ $order->phone }}<br>
                <br>
                <strong>_____________/_________</strong><br>
                <strong>ФИО</strong>
            </div>
        </div>
    </div>
</body>

</html>
