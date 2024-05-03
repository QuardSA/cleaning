<x-admin.header></x-admin.header>

<div class="container mt-5">
    <h2 class="text-start">Пользователи</h2>
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
                        <td class="d-flex gap-2"><a href=""><i class='edit bx bxs-edit bx-sm'
                                    style='color:green'></i></a>
                            <a href=""><i class='cancel bx bxs-x-circle bx-sm' style='color:red'></i></a>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" class="text-center">Пользователи отсутствуют</td>
                @endforelse
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </tbody>
        </table>
    </div>

    <script src="/script/sidebar.js"></script>
    </body>

    </html>
