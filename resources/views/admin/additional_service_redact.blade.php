<x-admin.header></x-admin.header>

<div class="container mt-4">
    <h1 class="text-center">
        Редактирование доп.услуги
    </h1>
    <form action="/additionalservice_validate/{{$additionalservice->id}}" class="d-flex flex-column gap-3 mt-4 mx-auto w-50" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="titleadditionalservices" placeholder="" value="{{$additionalservice->titleadditionalservices}}" name="titleadditionalservices">
            <label for="titleservice">Название</label>
            @error('titleservice')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="cost" placeholder="" value="{{$additionalservice->cost}}"  name="cost">
            <label for="cost">Цена за кв.м</label>
            @error('cost')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="work_time" value="{{$additionalservice->work_time}}" name="work_time">
            <label for="work_time">Время работы(в минутах за 1кв.м)</label>
            @error('work_time')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-info">Редактировать</button>
    </form>
</div>

<script src="/script/sidebar.js"></script>
<script src="/script/features.js"></script>
</body>
</html>
