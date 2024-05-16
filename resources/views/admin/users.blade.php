<x-admin.header></x-admin.header>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mt-5">
    <h2 class="text-start">Пользователи</h2>
    <form method="GET">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="user_id">Пользователь</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Все пользователи</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} {{ $user->surname }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="role">Роль</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">Все роли</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->titlerole }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Применить фильтр</button>
        <a href="/admin/users" class="btn btn-secondary mt-2">Сбросить фильтр</a>
    </form>
    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Почта</th>
                    <th>Роль</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->surname }} {{ $user->name }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_role->titlerole }}</td>
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
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect"
                                    aria-label="Floating label select example" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->titlerole }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="floatingSelect">Роль</label>
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
