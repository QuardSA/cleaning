<x-admin.header></x-admin.header>

<div class="container mt-5">
    <button type="button" class="bg-white border-0" data-bs-toggle="modal" data-bs-target="#createService">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить услугу</span>
    </button>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Цена/кв.м</th>
                    <th scope="col">Время работы</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $service->titleservice }}</td>
                        <td>{{ Illuminate\Support\Str::limit($service->description, 441) }}</td>
                        <td>{{ $service->cost }} рублей</td>
                        <td>{{ $service->work_time }} минут/кв.м</td>
                        <td class="">
                            <button type="button" class="edit-btn bg-white border-0" data-bs-toggle="modal"
                                data-bs-target="#editservice{{ $service->id }}">
                                <i class='edit bx bxs-edit bx-lg' style='color:green'></i>
                            </button>
                            <form action="{{ route('sevice_delete', $service->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-0 bg-white"><i class='cancel bx bxs-x-circle bx-md'
                                        style='color:red'></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Услуги отсутствуют</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $services->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
<div class="modal fade" id="createService" tabindex="-1" aria-labelledby="createService" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createService">Создать услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addservice_validate" class="d-flex flex-column gap-3 m-4 mx-auto w-75" method="POST">
                @csrf
                <div class="form-floating w-100">
                    <input type="text" class="form-control" id="titleservice" value="{{ old('titleservice') }}"
                        placeholder="" name="titleservice">
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
                    <input type="text" class="form-control" id="cost" value="{{ old('cost') }}"
                        placeholder="" name="cost">
                    <label for="cost">Цена за кв.м (В рублях)</label>
                    @error('cost')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating w-100">
                    <input type="text" class="form-control" id="work_time" value="{{ old('work_time') }}"
                        placeholder="" name="work_time">
                    <label for="work_time">Время работы(в минутах за 1 кв.м)</label>
                    @error('work_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
        </div>
    </div>
</div>
@foreach ($services as $service)
    <div class="modal fade" id="editservice{{ $service->id }}" tabindex="-1" aria-labelledby="editservice{{ $service->id }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editservice{{ $service->id }}Label">Редактировать услугу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/service_redact_validate/{{ $service->id }}" class="d-flex flex-column gap-3 m-4 mx-auto w-75" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="titleservice{{ $service->id }}" placeholder="" value="{{ $service->titleservice }}" name="titleservice">
                        <label for="titleservice{{ $service->id }}">Название</label>
                        @error('titleservice')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating w-100">
                        <textarea class="form-control" placeholder="" id="description{{ $service->id }}" style="height: 100px" name="description">{{ $service->description }}</textarea>
                        <label for="description{{ $service->id }}">Описание</label>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="cost{{ $service->id }}" placeholder="" value="{{ $service->cost }}" name="cost">
                        <label for="cost{{ $service->id }}">Цена за кв.м</label>
                        @error('cost')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="work_time{{ $service->id }}" value="{{ $service->work_time }}" name="work_time">
                        <label for="work_time{{ $service->id }}">Время работы (в минутах за 1 кв.м)</label>
                        @error('work_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
                    <button type="submit" class="btn btn-info">Редактировать</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="/script/sidebar.js"></script>
</body>

</html>
