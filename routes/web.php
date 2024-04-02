<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/signin', function () {
    return view('signin');
});

Route::get('/object', function () {
    return view('object');
});

Route::get('/personal', function () {
    return view('personal');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/services', function () {
    return view('services');
});


Route::get('/admin', function () {
    return view('admin.index');
});
Route::get('/admin/orders', function () {
    return view('admin.orders');
});
