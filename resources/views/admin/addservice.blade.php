<x-admin.header></x-admin.header>
<div class="container mt-5 form-admin">
    <h1 class="text-center">
        Создание услуги
    </h1>
    <form action="/addservice_validate" class="d-flex flex-column gap-3 mt-4 mx-auto" method="POST">
        @csrf
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="titleservice" value="{{ old('titleservice') }}" placeholder=""
                name="titleservice">
            <label for="titleservice">Название</label>
            @error('titleservice')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <textarea class="form-control" placeholder="" id="description" style="height: 100px" name="description">{{ old('description') }}</textarea>
            <label for="description">Описание</label>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="cost" value="{{ old('cost') }}" placeholder=""
                name="cost">
            <label for="cost">Цена за кв.м (В рублях)</label>
            @error('cost')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating w-100">
            <input type="text" class="form-control" id="work_time" value="{{ old('work_time') }}" placeholder=""
                name="work_time">
            <label for="work_time">Время работы(в минутах за 1 кв.м)</label>
            @error('work_time')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div id="featurescontainer" class="d-flex flex-column gap-3">
            <div class="form-floating w-100">
                <input type="text" class="form-control" id="titlefeatures" placeholder="" name="titlefeatures[]">
                <label for="titlefeatures">Особенности</label>
                @error('titlefeatures[]')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-outline">
            <h3 class="fw-normal text-start">Дополнительные услуги</h3>
            @foreach ($additionalServices as $additionalService)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $additionalService->id }}"
                        id="additionalservice{{ $additionalService->id }}" name="additionalservices[]">
                    <label class="form-check-label" for="additionalservice{{ $additionalService->id }}">
                        {{ $additionalService->titleadditionalservices }} | {{ $additionalService->cost }} руб
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-info">Добавить</button>
    </form>
    <button class="btn btn-primary mx-auto d-block mt-2 w-100" onclick="addfeatures()">Добавить особенность</button>
</div>

<script src="/script/sidebar.js"></script>
<script src="/script/features.js"></script>
</body>

</html>
