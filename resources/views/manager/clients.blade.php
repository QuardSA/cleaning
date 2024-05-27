<x-admin.header></x-admin.header>
<div class="container mt-5">
    <h2 class="text-start mt-3">Клиенты</h2>
    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Почта</th>
                    <th>Номер телефона</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                @empty
                    <td colspan="4" class="text-center">Клиенты отсутствуют</td>
                @endforelse
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/script/sidebar.js"></script>
    <x-scripts></x-scripts>
    </body>

    </html>
