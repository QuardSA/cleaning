<x-admin.header></x-admin.header>
<div class="container mt-4">
    <h1 class="text-center">
        Редактирование услуги
    </h1>
    <form action="/service_redact_validate" class="d-flex flex-column gap-3 mt-4 mx-auto w-50" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="titleservice" placeholder="" value="{{$service->titleservice}}" name="titleservice">
            <label for="titleservice">Название</label>
        </div>
        <div class="form-floating w-100">
            <textarea class="form-control" placeholder="" id="description"  style="height: 100px" name="description">{{$service->description}}</textarea>
            <label for="description">Описание</label>
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="cost" placeholder="" value="{{$service->cost}}"  name="cost">
            <label for="cost">Цена</label>
        </div>
        <div id="featurescontainer" class="d-flex flex-column gap-3">
            <div class="form-floating w-100">
                <input type="text" class="form-control" id="titlefeatures" placeholder="" value="{{$service->titlefeatures}}"  name="titlefeatures">
                <label for="titlefeatures">Функция</label>
            </div>
        </div>
        <div class="input-group input-group-lg">
            <input type="file" class="form-control" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03" value="{{$service->photo}}" aria-label="Upload" name="photo">
        </div>
        <button type="submit" class="btn btn-info">Редактировать</button>
    </form>
    <div class="d-flex"></div>
        <button class="btn btn-primary w-50 mx-auto d-block mt-2" onclick="addfeatures()">Добавить функции</button>
</div>


<script src="/script/sidebar.js"></script>
<script src="/script/features.js"></script>
</body>
</html>