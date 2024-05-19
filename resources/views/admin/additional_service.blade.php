<x-admin.header></x-admin.header>

<div class="container mt-5">
    <a href="/admin/add_additional_service" class="d-flex text-decoration-none text-dark align-items-center gap-2">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить доп.услугу</span>
    </a>
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
                        <td>{{ $additionalservice->work_time}} минут</td>
                        <td class="d-flex">
                            <a href="/admin/additional_service_redact/{{$additionalservice->id}}"><i class='edit bx bxs-edit bx-md' style='color:green'></i></a>
                            <form action="{{ route('additionalservice_delete',$additionalservice->id)}}" method="POST">
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
            {{ $additionalservices->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="/script/sidebar.js"></script>
</body>
</html>
