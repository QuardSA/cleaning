<x-admin.header></x-admin.header>

<div class="container mt-4">
    <a href="/admin/addservice" class="d-flex text-decoration-none text-dark align-items-center gap-2">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить услугу</span>
    </a>
    <div class="row mt-2">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Изображение</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Особенности</th>
                        <th scope="col">Цена/кв.м</th>
                        <th scope="col">Время работы</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                    <tr>
                        <td class="w-25"><img src="/storage/images/{{$service->photo}}" class="img-fluid"></td>
                        <td>{{ $service->titleservice }}</td>
                        <td>{{ Illuminate\Support\Str::limit($service->description, 441) }}</td>
                        <td>
                            <ul class="list-style-none">
                                @forelse ($service->features as $feature)
                                <li class="list-group">{{ $feature->titlefeatures }}</li>
                                @empty
                                <li>нету особенностей</li>
                                @endforelse
                            </ul>
                        </td>
                        <td>{{ $service->cost }} рублей</td>
                        <td>{{ $service->work_time}} минут/кв.м</td>
                        <td>
                            <a href="/admin/servicerdact/{{$service->id}}" class="btn btn-outline-success mb-2">Редактировать</a>
                            <form action="{{ route('sevice_delete',$service->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">Удалить</button>
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
</div>

<script src="/script/sidebar.js"></script>
</body>
</html>
