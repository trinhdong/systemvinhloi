<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN'])->group(function () {
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
        Route::delete('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.update');
        Route::delete('/delete-discount/{discountId}', [CustomerController::class, 'deleteDiscount'])->name(
            'customer.deleteDiscount'
        );
    });
    Route::prefix('bank-account')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('bank_account.index');
        Route::get('/detail/{id}', [BankAccountController::class, 'detail'])->name('bank_account.detail');
        Route::delete('/delete/{id}', [BankAccountController::class, 'delete'])->name('bank_account.delete');
        Route::get('/edit/{id}', [BankAccountController::class, 'edit'])->name('bank_account.edit');
        Route::put('/edit/{id}', [BankAccountController::class, 'edit'])->name('bank_account.update');
        Route::get('/add', [BankAccountController::class, 'add'])->name('bank_account.add');
        Route::post('/add', [BankAccountController::class, 'add'])->name('bank_account.create');
    });
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,WAREHOUSE_STAFF,STOCKER'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,STOCKER'])->group(function () {
    Route::controller(CategoryController::class)->prefix('category')->group(function () {
        Route::get('/', 'index')->name('category.list');
        Route::get('/add', 'show')->name('category.create.show');
        Route::post('/add', 'create')->name('category.create.post');
        Route::get('/detail/{id}', 'detail')->name('category.detail');
        Route::get('/edit/{id}', 'edit')->name('category.edit');
        Route::post('/edit/{id}', 'update')->name('category.update');
        Route::delete('/delete/{id}', 'delete')->name('category.delete');
    });
    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index')->name('product.list');
        Route::get('/add', 'show')->name('product.create.show');
        Route::post('/add', 'create')->name('product.create.post');
        Route::get('/detail/{id}', 'detail')->name('product.detail');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::post('/edit/{id}', 'update')->name('product.update');
        Route::delete('/delete/{id}', 'delete')->name('product.delete');
    });
});

Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,SALE'])->group(function () {
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/detail/{id}', [CustomerController::class, 'detail'])->name('customer.detail');
        Route::get('/add', [CustomerController::class, 'add'])->name('customer.add');
        Route::post('/add', [CustomerController::class, 'add'])->name('customer.create');
        Route::get('/customer-info/{id}', [CustomerController::class, 'getCustomerInfo'])->name('customer.getCustomerInfo');
        Route::get('/search-product',  [CustomerController::class, 'searchProduct'])->name('customer.searchProduct');
    });
    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/getByCategoryId',  'getByCategoryId')->name('product.getByCategoryId');
        Route::get('/search-product',  'searchProduct')->name('product.searchProduct');
    });
    Route::controller(AreaController::class)->prefix('area')->group(function () {
        Route::get('/', 'index')->name('area.list');
        Route::get('/add', 'show')->name('area.create.show');
        Route::post('/add', 'create')->name('area.create.post');
        Route::get('/detail/{id}', 'detail')->name('area.detail');
        Route::get('/edit/{id}', 'edit')->name('area.edit');
        Route::post('/edit/{id}', 'update')->name('area.update');
        Route::delete('/delete/{id}', 'delete')->name('area.delete');
    });
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,SALE,ACCOUNTANT'])->group(function () {
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('order.detail');
    });
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,SALE'])->group(function () {
    Route::prefix('order')->group(function () {
        Route::delete('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('/edit/{id}', [OrderController::class, 'edit'])->name('order.update');
        Route::get('/add', [OrderController::class, 'add'])->name('order.add');
        Route::post('/add', [OrderController::class, 'add'])->name('order.create');
        Route::delete('/delete-order-detail/{orderDetailId}', [OrderController::class, 'deleteOrderDetail'])->name(
            'order.deleteOrderDetail'
        );
        Route::put('/update-status-order/{id}/{status?}', [OrderController::class, 'updateStatusOrder'])->name(
            'order.updateStatusOrder'
        );
        Route::put('/update-status-payment/{id}}', [OrderController::class, 'updateStatusPayment'])->name(
            'order.updateStatusPayment'
        );
        Route::get('/getDiscountByCustomerId',  [OrderController::class, 'getDiscountByCustomerId'])->name('order.getDiscountByCustomerId');
        Route::get('/getBankAccountById/{id}',  [OrderController::class, 'getBankAccountById'])->name('order.getBankAccountById');
        Route::get('/print-invoice/{id}',  [OrderController::class, 'printInvoice'])->name('order.printInvoice');
        Route::get('/print-delivery-bill/{id}/{isDelivery}',  [OrderController::class, 'printInvoice'])->name('order.printDeliveryBill');
    });
});

Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,WAREHOUSE_STAFF'])->group(function () {
    Route::prefix('/warehouse-staff/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('warehouse-staff.order.index');
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('warehouse-staff.order.detail');
    });
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,STOCKER'])->group(function () {
    Route::prefix('/stocker/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('stocker.order.index');
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('stocker.order.detail');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('stocker.order.edit');
        Route::put('/edit/{id}', [OrderController::class, 'edit'])->name('stocker.order.update');
        Route::put('/update-status-order/{id}/{status?}', [OrderController::class, 'updateStatusOrder'])->name(
            'stocker.order.updateStatusOrder'
        );
    });
    Route::get('/print-invoice/{id}',  [OrderController::class, 'printInvoice'])->name('stocker.order.printInvoice');
    Route::get('/print-delivery-bill/{id}/{isDelivery}',  [OrderController::class, 'printInvoice'])->name('stocker.order.printDeliveryBill');
});
Route::middleware(['auth', 'checkRole:SUPER_ADMIN,ADMIN,ACCOUNTANT'])->group(function () {
    Route::prefix('/payment')->group(function () {
        Route::get('/', [OrderController::class, 'indexPayment'])->name('payment.indexPayment');
        Route::get('/detail-payment/{id}', [OrderController::class, 'detailPayment'])->name('payment.detailPayment');
        Route::put('/update-status-payment/{id}/{status?}', [OrderController::class, 'updateStatusPayment'])->name(
            'payment.updateStatusPayment'
        );
        Route::put('/update-payment/{id}', [OrderController::class, 'updatePayment'])->name(
            'payment.updatePayment'
        );
        Route::get('/getBankAccountById/{id}',  [OrderController::class, 'getBankAccountById'])->name('payment.getBankAccountById');
    });
});
