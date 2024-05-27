<x-admin.header></x-admin.header>

<div class="container mt-5">
    <h2 class="text-start">Панель Менеджера</h2>
    <div class="row gap-2 mt-3 justify-content-start">
        <div class="rounded col bg-success bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">{{ $users }}</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Клиенты</p>
            </div>
            <a href="/manager/clients"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
        <div class="rounded col bg-primary bg-gradient px-0" style="max-width: 310px">
            <div class="inner px-2">
                <h3 class="text-white fw-semibold mt-2">{{ $newOrdersCount }}</h3>
                <p class="text-white fs-5 mt-0 fw-semibold">Новые заявки</p>
            </div>
            <a href="/manager/orders"
                class=" box-link border-none rounded-bottom d-block text-white fs-5 text-decoration-none text-center">
                <span class="d-inline-block">Больше</span>
                <i class='bx bxs-right-arrow-circle'></i>
            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6">
            <div class="order_chart border-none shadow rounded p-3">
                <h3 class="text-center">Рассылка</h3>
                <div class="container border rounded d-flex flex-column overflow-auto" style="height:36vh">
                    <button type="button" class="border-0 bg-white" data-bs-toggle="modal"
                        data-bs-target="#createMailing"><i class='bx bx-plus-circle bx-md text-center'></i></button>
                    @forelse ($mailings as $mailing)
                        <div class="border rounded p-1 d-flex align-items-center mt-1 ">
                            <div class="d-flex flex-grow-1 align-items-center gap-1">
                                <i class='bx bxs-envelope bx-md'></i>
                                <span>{{ $mailing->titlemailing }}</span>
                            </div>
                            <a href="/mailing_repeat/{{ $mailing->id }}"><i
                                    class='bx bx-sync text-primary bx-md'></i></a>
                            <button type="button" class="border-0 bg-white" data-bs-toggle="modal"
                                data-bs-target="#editMailing{{ $mailing->id }}"><i
                                    class='bx bxs-edit bx-md text-success'></i></button>
                            <a href="/mailing_delete/{{ $mailing->id }}" class="text-danger"><i
                                    class='cancel bx bxs-x-circle bx-md text-danger'></i></a>
                        </div>
                    @empty
                        <p class="text-center">Тут ничего нет</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="createMailing" tabindex="-1" aria-labelledby="createMailing" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMailing">Создание рассылки</h5> <button type="button"
                    class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createMailing" method="POST" action="/mailing">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editQuestion" name="titlemailing" required>
                        <label for="editQuestion" class="form-label">Тема рассылки</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="editAnswer" name="description" style="height: 150px" required></textarea>
                        <label for="editAnswer" class="form-label">Описание</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach ($mailings as $mailing)
    <div class="modal fade" id="editMailing{{ $mailing->id }}" tabindex="-1"
        aria-labelledby="editMailing{{ $mailing->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMailing">Редактирование рассылки</h5> <button type="button"
                        class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMailing" method="POST" action="/mailing_edit/{{ $mailing->id }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editQuestion" name="titlemailing"
                                value="{{ $mailing->titlemailing }}" required>
                            <label for="editQuestion" class="form-label">Тема рассылки</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="editAnswer" name="description" style="height: 150px" required>{{ $mailing->description }}</textarea>
                            <label for="editAnswer" class="form-label">Описание</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Редактировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="/script/sidebar.js"></script>
<x-scripts></x-scripts>

</html>
