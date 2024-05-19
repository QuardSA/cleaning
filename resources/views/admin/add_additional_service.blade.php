<x-admin.header></x-admin.header>
<div class="container mt-4">
    <h1 class="text-center">
        Создание доп.услуги
    </h1>
    <form action="/add_additional_service_validate" class="d-flex flex-column gap-3 mt-4 mx-auto w-50" method="POST">
        @csrf
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="titleadditionalservices" value="{{old('titleadditionalservices')}}" placeholder="" name="titleadditionalservices">
            <label for="titleadditionalservices">Название</label>
            @error('titleadditionalservices')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="cost" placeholder="{{old('cost')}}" name="cost">
            <label for="cost">Цена(В рублях)</label>
            @error('cost')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="work_time" placeholder="{{old('work_time')}}" name="work_time">
            <label for="work_time">Время работы(в минутах)</label>
            @error('work_time')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-info">Добавить</button>
    </form>
</div>
<script src="/script/sidebar.js"></script>
</body>
</html>
