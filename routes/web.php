<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/edit/{id}', [UserController::class, 'edit'])->name('user.update');
        Route::get('/add', [UserController::class, 'add'])->name('user.add');
        Route::post('/add', [UserController::class, 'add'])->name('user.create');
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/detail/{id}', [CustomerController::class, 'detail'])->name('customer.detail');
        Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.update');
        Route::get('/add', [CustomerController::class, 'add'])->name('customer.add');
        Route::post('/add', [CustomerController::class, 'add'])->name('customer.create');
        Route::delete('/delete-discount/{discountId}', [CustomerController::class, 'deleteDiscount'])->name('customer.deleteDiscount');
    });

    Route::prefix('product')->group(function () {
        Route::get('/getByCategoryId', [ProductController::class, 'getByCategoryId'])->name('product.getByCategoryId');
    });

    Route::controller(AreaController::class)->prefix('area')->group(function () {
        Route::get('/', 'index')->name('area.list');
        Route::get('/create', 'show')->name('area.create.show');
        Route::post('/create', 'create')->name('area.create.post');
    });
});
