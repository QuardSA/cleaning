<?php

use Illuminate\Support\Facades\Route;
use App\Exports\Report;
use App\Imports\ReportsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\http\Controllers\AdminController;
use App\http\Controllers\AuthorizationController;
use App\http\Controllers\MailingController;
use App\http\Controllers\MainController;
use App\http\Controllers\ManagerController;
use App\http\Controllers\UserController;
use App\http\Controllers\LogController;
use App\Http\Middleware\CheckRole;

Route::get('/signout', [AuthorizationController::class, "signout"])->middleware('CheckAuth');

Route::middleware(['Redirect'])->group(function () {
    Route::get('/', [MainController::class, "index"]);
    Route::post('/comments_validate', [MainController::class, "comments_validate"]);
    Route::get('/object/{id}', [MainController::class, "object"]);
    Route::post('/create_order_validate', [MainController::class, "create_order_validate"]);
    Route::post('/cancel-order/{id}', [MainController::class, 'cancelOrder'])->name('cancel-order');
    Route::post('/signup_validation', [AuthorizationController::class, "signup_validation"]);
    Route::post('/signin_validation', [AuthorizationController::class, "signin_validation"]);
    Route::post('/mailing_validation', [MailingController::class, "mailing_validation"]);
});

Route::middleware(['CheckAuth', 'CheckRole:1'])->group(function () {
    Route::get('/personal', [UserController::class, "personal"]);
    Route::get('/profile', [UserController::class, "profile"]);
    Route::post('/update_profile', [UserController::class, "update_profile"]);
});

Route::middleware(['CheckRole:2'])->group(function () {
    Route::get('/admin', [AdminController::class, "index"]);
    Route::post('/admin/filter', [AdminController::class, "filterData"])->name('admin.filter');
    Route::get('/admin/logs', [LogController::class, "logs"]);
    Route::get('/admin/users', [AdminController::class, "users"]);
    Route::get('/admin/users/{id}/edit', [AdminController::class, "users_edit"]);
    Route::put('/users_edit_validate/{id}', [AdminController::class, "users_edit_validate"]);
    Route::get('/delete/{id}', [AdminController::class, "users_delete"]);
    Route::get('/admin/service', [AdminController::class, "service"]);
    Route::get('/admin/additional_service', [AdminController::class, "additional_service"]);
    Route::get('/admin/addservice', [AdminController::class, "addservice"]);
    Route::get('/admin/add_additional_service', [AdminController::class, "add_additional_service"]);
    Route::post('/addservice_validate', [AdminController::class, "addservice_validate"]);
    Route::post('/add_additional_service_validate', [AdminController::class, "add_additional_service_validate"]);
    Route::post('/filter', [AdminController::class, "filter"]);
    Route::get('/admin/servicerdact/{id}', [AdminController::class, "service_redact"]);
    Route::get('/admin/additional_service_redact/{id}', [AdminController::class, "additionalservice_redact"]);
    Route::put('/service_redact_validate/{id}', [AdminController::class, "service_redact_validate"]);
    Route::put('/additionalservice_validate/{id}', [AdminController::class, "additionalservice_validate"]);
    Route::delete('/admin/service_delete/{id}', [AdminController::class, "service_delete"])->name('sevice_delete');
    Route::delete('/admin/additionalservice_delete/{id}', [AdminController::class, "additionalservice_delete"])->name('additionalservice_delete');
});
Route::middleware(['CheckRole:3'])->group(function () {
    Route::get('/manager', [ManagerController::class, "index"]);
    Route::post('/manager/faq_create', [ManagerController::class, "faq_create"]);
    Route::put('/manager/faq_edit/{id}', [ManagerController::class, "faq_edit"]);
    Route::get('/faq_delete/{id}', [ManagerController::class, "faq_delete"]);
    Route::get('/manager', [ManagerController::class, "index"]);
    Route::get('/manager/faq', [ManagerController::class, "faq"]);
    Route::post('/mailing', [ManagerController::class, "mailing"]);
    Route::post('/mailing_edit/{id}', [ManagerController::class, "mailing_edit"]);
    Route::get('/mailing_repeat/{id}', [ManagerController::class, "mailing_repeat"]);
    Route::get('/mailing_delete/{id}', [ManagerController::class, "mailing_delete"]);
    Route::get('/manager/orders', [ManagerController::class, "orders"]);
    Route::post('/manager/orders/{id}/accept', [ManagerController::class, "accept"])->name('orders.accept');
    Route::post('/manager/orders/{id}/deny', [ManagerController::class, "deny"])->name('orders.deny');
    Route::get('/export', [ManagerController::class, "report"]);
    Route::get('/downloadReport/{filename}', [ManagerController::class, "downloadReport"]);
    Route::get('/deleteReport/{id}', [ManagerController::class, "deleteReport"]);
});
