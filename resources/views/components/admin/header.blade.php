<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-links></x-links>
    <x-alerts></x-alerts>
    <title>Document</title>
</head>

<body>
    <nav class="navbar-admin position-fixed top-0 start-0 d-flex align-items-center" style="width:15%">
        <div class="logo d-flex align-items-center mt-2 ms-2 gap-3">
            <i class="bx bx-menu menu-icon bx-lg"></i>
        </div>
        <div class="sidebar position-fixed top-0 h-100 px-2 shadow bg-white" style="width:15%">
            <div class="logo d-flex align-items-center mt-2 ms-2 gap-3">
                <i class="bx bx-menu menu-icon bx-lg"></i>
                <div class="d-flex flex-column">
                    <span class="logo-name fs-4">{{ Auth::user()->name }} {{ Auth::user()->surname }}</span>
                    <span class="logo-name fs-6">{{ Auth::user()->user_role->titlerole }}</span>
                </div>
            </div>
            <hr>
            @if (Auth::user()->role == 2)
                <div class="sidebar-content" style="height:82%">
                    <ul class="lists list-group mt-3 gap-1">
                        <li class="nav-item">
                            <a href="/admin"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bxs-dashboard bx-sm'></i>
                                Главная
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bx-group bx-sm'></i>
                                Пользователи
                            </a>
                        </li>
                        <li>
                            <a href="/admin/service"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bx-table bx-sm icon'></i>
                                Услуги
                            </a>
                        </li>
                        <li>
                            <a href="/admin/logs"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bx-file bx-sm'></i>
                                Логи
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            @if (Auth::user()->role == 3)
                <div class="sidebar-content" style="height:82%">
                    <ul class="lists list-group mt-3 gap-1">
                        <li class="nav-item">
                        <li class="nav-item">
                            <a href="/manager"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bxs-dashboard bx-sm'></i>
                                Главная
                            </a>
                        </li>
                        <a href="/manager/orders"
                            class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                            <i class='bx bxs-dashboard bx-sm'></i>
                            Заявки
                        </a>
                        </li>
                        <li class="nav-item">
                            <a href="/manager/faq"
                                class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                                <i class='bx bxs-dashboard bx-sm'></i>
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
            <hr>
            <div class="bottom mt-auto">
                <a href="/signout" class="nav-link nav-style active d-flex align-items-center gap-2 rounded p-1">
                    <i class='bx bxs-log-out bx-sm icon'></i>
                    <strong>Выход</strong>
                </a>
            </div>
        </div>
    </nav>
