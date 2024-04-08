<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\AdminController;
use App\http\Controllers\AuthorizationController;
use App\http\Controllers\MailingController;
use App\http\Controllers\MainController;
use App\http\Controllers\UserController;

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

Route::get('/',[MainController::class, "index"]);

Route::post('/signup_validation',[AuthorizationController::class, "signup_validation"]);
Route::post('/signin_validation',[AuthorizationController::class, "signin_validation"]);
Route::get('/signout',[AuthorizationController::class, "signout"]);

Route::post('/mailing_validation',[MailingController::class, "mailing_validation"]);

Route::get('/object', function () {
    return view('object');
});

Route::get('/personal',[UserController::class, "personal"]);
Route::get('/profile',[UserController::class, "profile"]);
Route::post('/update_profile',[UserController::class, "update_profile"]);

Route::get('/admin',[AdminController::class, "index"]);
Route::get('/admin/orders',[AdminController::class, "orders"]);
Route::get('/admin/addservice',[AdminController::class, "addservice"]);
Route::post('/addservice_validate',[AdminController::class, "addservice_validate"]);
Route::get('/admin/servicerdact/{id}',[AdminController::class, "service_redact"]);
Route::put('/service_redact_validate/{id}',[AdminController::class, "service_redact_validate"]);
Route::delete('/admin/service_delete/{id}',[AdminController::class, "service_delete"])->name('sevice_delete');
