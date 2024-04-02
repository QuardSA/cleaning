<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-links></x-links>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm mt-2">
        <div class="container">
          <a class="navbar-brand" href="/">Панель навигации</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Главная</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/services">Услуги</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/profile">Отзывы</a>
              </li>
            </ul>
            <ul class="navbar-nav gap-1">
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-primary rounded-pill">
                        Личный кабинет
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Регистрация
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-danger rounded-pill">
                        Выход
                    </button>
                </li>
            </ul>
          </div>
        </div>
    </nav>
    <div class="container">
    <hr>
<x-reg></x-reg>
