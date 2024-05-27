<x-admin.header></x-admin.header>

<div class="container mt-5">
    <button type="button" class="bg-white border-0" data-bs-toggle="modal" data-bs-target="#createAdditService">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить доп.услугу</span>
    </button>
    <div class="row mt-2">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Время работы</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($additionalservices as $additionalservice)
                        <tr>
                            <td>{{ $additionalservice->titleadditionalservices }}</td>
                            <td>{{ $additionalservice->cost }} рублей</td>
                            <td>{{ $additionalservice->work_time }} минут</td>
                            <td class="d-flex">
                                <button type="button" class="edit-btn bg-white border-0" data-bs-toggle="modal"
                                    data-bs-target="#editadditservice{{ $additionalservice->id }}">
                                    <i class='edit bx bxs-edit bx-md' style='color:green'></i>
                                </button>
                                <form action="{{ route('additionalservice_delete', $additionalservice->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-white"><i
                                            class='cancel bx bxs-x-circle bx-md' style='color:red'></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Услуги отсутствуют</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            {{ $additionalservices->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
<div class="modal fade" id="createAdditService" tabindex="-1" aria-labelledby="createAdditService" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAdditService">Создать доп.услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/add_additional_service_validate" class="d-flex flex-column gap-3 m-4 mx-auto w-75"
                method="POST">
                @csrf
                <div class="form-floating w-100">
                    <input type="text" class="form-control" id="titleadditionalservices"
                        value="{{ old('titleadditionalservices') }}" placeholder="" name="titleadditionalservices">
                    <label for="titleadditionalservices">Название</label>
                    @error('titleadditionalservices')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating w-100">
                    <input type="text" class="form-control" id="cost" placeholder="{{ old('cost') }}"
                        name="cost">
                    <label for="cost">Цена(В рублях)</label>
                    @error('cost')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-floating w-100">
                    <input type="text" class="form-control" id="work_time" placeholder="{{ old('work_time') }}"
                        name="work_time">
                    <label for="work_time">Время работы(в минутах)</label>
                    @error('work_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-info">Добавить</button>
            </form>
        </div>
    </div>
</div>
@foreach ($additionalservices as $additionalservice)
    <div class="modal fade" id="editadditservice{{ $additionalservice->id }}" tabindex="-1"
        aria-labelledby="editadditservice{{ $additionalservice->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editadditservice">Редактировать доп.услугу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/additionalservice_validate/{{ $additionalservice->id }}"
                    class="d-flex flex-column gap-3 m-4 mx-auto w-75" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="titleadditionalservices" placeholder=""
                            value="{{ $additionalservice->titleadditionalservices }}" name="titleadditionalservices">
                        <label for="titleservice">Название</label>
                        @error('titleservice')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="cost" placeholder=""
                            value="{{ $additionalservice->cost }}" name="cost">
                        <label for="cost">Цена за кв.м</label>
                        @error('cost')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-floating w-100">
                        <input type="text" class="form-control" id="work_time"
                            value="{{ $additionalservice->work_time }}" name="work_time">
                        <label for="work_time">Время работы(в минутах за 1кв.м)</label>
                        @error('work_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
