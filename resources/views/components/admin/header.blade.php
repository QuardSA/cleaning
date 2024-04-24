<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                <span class="logo-name fs-4">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                <span class="logo-name fs-6">{{Auth::user()->user_role->titlerole}}</span>
            </div>
        </div>
        <div class="sidebar-content ">
            <ul class="lists list-group mt-3 gap-2">
                <li class="list">
                    <a href="/admin" class="nav-link nav-style d-flex align-items-center p-3 gap-2">
                        <i class='bx bx-table bx-md icon'></i>
                        <span class="link fs-5 fw-bold">Главная</span>
                    </a>
                </li>
                <li class="list">
                    <a href="/admin/service" class="nav-link nav-style d-flex align-items-center p-3 gap-2">
                        <i class='bx bx-table bx-md icon'></i>
                        <span class="link fs-5 fw-bold">Услуги</span>
                    </a>
                </li>
                <li class="list">
                    <a href="/admin/orders" class="nav-link nav-style d-flex align-items-center p-3 gap-2">
                        <i class='bx bx-receipt bx-md icon'></i>
                        <span class="link fs-5 fw-bold">Заявки</span>
                    </a>
                </li>
                <li class="list">
                    <a href="/signout" class="nav-link nav-style d-flex align-items-center p-3 gap-2">
                        <i class='bx bxs-log-out bx-md icon'></i>
                        <span class="link fs-5 fw-bold">Выход</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


