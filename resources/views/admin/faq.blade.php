<x-admin.header></x-admin.header>

<div class="container mt-5">
    <button type="button" class="bg-white border-0" data-bs-toggle="modal" data-bs-target="#createFAQModal">
        <i class='bx bx-plus-circle bx-sm'></i>
        <span class="fs-5">Добавить вопрос</span>
    </button>

    <div class="table-responsive mt-1">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faqs as $faq)
                    <tr>
                        <td>{{ $faq->titlefaq }}</td>
                        <td>{{ $faq->description }}</td>
                        <td class="d-flex gap-2 h-100">
                            <button type="button" class="edit-btn bg-white border-0" data-bs-toggle="modal"
                                data-bs-target="#editFAQModal{{ $faq->id }}">
                                <i class='edit bx bxs-edit bx-lg' style='color:green'></i>
                            </button>
                            <a href="/faq_delete/{{ $faq->id }}"><i class='cancel bx bxs-x-circle bx-lg'
                                    style='color:red'></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">FAQ's отсутствуют</td>
                    </tr>
                @endforelse
                {{ $faqs->withQueryString()->links('pagination::bootstrap-5') }}
            </tbody>
        </table>
    </div>

</div>
<div class="modal fade" id="createFAQModal" tabindex="-1" aria-labelledby="createFAQModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFAQModal">Создать FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFAQForm" method="POST" action="/admin/faq_create">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editQuestion" name="titlefaq" required>
                        <label for="editQuestion" class="form-label">Тема вопроса</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="editAnswer" name="description" style="height: 100px" required></textarea>
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
@foreach ($faqs as $faq)
    <div class="modal fade" id="editFAQModal{{ $faq->id }}" tabindex="-1"
        aria-labelledby="editFAQModalLabel{{ $faq->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Редактировать FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editFAQForm{{ $faq->id }}" method="POST" action="/admin/faq_edit/{{ $faq->id }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editQuestion{{ $faq->id }}"
                                name="titlefaq" value="{{ $faq->titlefaq }}" required>
                            <label for="editQuestion{{ $faq->id }}" class="form-label">Тема вопроса</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="editAnswer{{ $faq->id }}" name="description" style="height: 100px" required>{{ $faq->description }}</textarea>
                            <label for="editAnswer{{ $faq->id }}" class="form-label">Описание</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
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
</body>

</html>
