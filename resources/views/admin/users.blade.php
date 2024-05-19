<x-admin.header></x-admin.header>
<div class="container mt-5">
    <button type="button" data-bs-toggle="modal" data-bs-target="#createUserModal"
    class="d-flex text-decoration-none text-dark align-items-center gap-2 bg-white border-0">
    <i class='bx bx-plus-circle bx-sm'></i>
    <span class="fs-5">Добавить менеджера</span>
</button>
    <h2 class="text-start mt-3">Менеджеры</h2>

    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Почта</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->surname }} {{ $user->name }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-flex gap-2">
                            <button type="button" class="edit-btn bg-white border-0" data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">
                                <i class='edit bx bxs-edit bx-sm' style='color:green'></i>
                            </button>
                            <a href="/delete/{{ $user->id }}"><i class='cancel bx bxs-x-circle bx-sm'
                                    style='color:red'></i></a>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" class="text-center">Пользователи отсутствуют</td>
                @endforelse
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </tbody>
        </table>
    </div>
    @foreach ($users as $user)
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Редактировать пользователя</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editUserForm" method="POST" action="/users_edit_validate/{{ $user->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editUserName" name="surname"
                                    value="{{ $user->surname }}">
                                <label for="editUserName" class="form-label">Фамилия</label>
                                @error('surname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editUserName" name="name"
                                    value="{{ $user->name }}">
                                <label for="editUserName" class="form-label">Имя</label>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editUserName" name="lastname"
                                    value="{{ $user->lastname }}">
                                <label for="editUserName" class="form-label">Отчество</label>
                                @error('lastname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="editUserEmail" name="email"
                                    value="{{ $user->email }}">
                                <label for="editUserEmail" class="form-label">Email</label>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="editUserPassword" name="password"
                                    value="">
                                <label for="editUserEmail" class="form-label">Пароль</label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Добавить менеджера</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createUserForm" method="POST" action="/users_create_validate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="userSurname" name="surname" value="">
                            <label for="userSurname" class="form-label">Фамилия</label>
                            @error('surname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="userName" name="name" value="">
                            <label for="userName" class="form-label">Имя</label>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="userLastname" name="lastname" value="">
                            <label for="userLastname" class="form-label">Отчество</label>
                            @error('lastname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="userEmail" name="email" value="">
                            <label for="userEmail" class="form-label">Email</label>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="userPassword" name="password" value="">
                            <label for="userPassword" class="form-label">Пароль</label>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/script/sidebar.js"></script>
    <x-scripts></x-scripts>
    </body>

    </html>
