<x-admin.header></x-admin.header>
<div class="container mt-4">
    <a href="/admin/addservice" class="d-flex text-decoration-none text-dark align-items-center gap-2">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class=" fs-5">Добавить услугу</span>
    </a>
    <div class="row row-cols-1 row-cols-md-2 g-4 mt-2">
        <div class="col">
            @forelse ($services as $service)
            <div class="card">
                <img src="/img/1.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $service->titleservice }}</h5>
                    <p class="card-text">{{ $service->description }}</p>
                    <p class="card-text">Цена: {{ $service->cost }} рублей</p>
                    <div class="d-flex justify-content-between">
                        <a href="/admin/servicerdact/" class="btn btn-outline-success">Редактировать</a>
                        <form action="{{ route('sevice_delete',$service->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <h2 class="text-center">Услуги отсутсвуют</h2>
            </div>
            @endforelse
        </div>
    </div>
</div>


<script src="/script/sidebar.js"></script>
</body>
</html>
