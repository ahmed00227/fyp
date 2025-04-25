<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/',function(){
        return 234;
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::post('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('order.update-status');
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('/doctor/dashboard', [\App\Http\Controllers\DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::get('/doctor/chat/{id}', [\App\Http\Controllers\DoctorController::class, 'chat'])->name('chat');
    Route::post('/chat/{id}', [\App\Http\Controllers\DoctorController::class, 'messageSend'])->name('chat.send');
    Route::put('/products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::get('/product/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [\App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::delete('/product/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
});

