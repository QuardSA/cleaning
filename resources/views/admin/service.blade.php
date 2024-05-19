<x-admin.header></x-admin.header>

<div class="container mt-5">
    <a href="/admin/addservice" class="d-flex text-decoration-none text-dark align-items-center gap-2 ">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить услугу</span>
    </a>
    <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
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
                        <td class="">
                            <a href="/admin/servicerdact/{{$service->id}}"><i class='edit bx bxs-edit bx-md' style='color:green'></i></a>
                            <form action="{{ route('sevice_delete',$service->id)}}" method="POST">
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

<script src="/script/sidebar.js"></script>
</body>
</html>
