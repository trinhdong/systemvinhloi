<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware('auth')->group(function () {
//    dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });
    //user
//    Route::controller(UserController::class)->group(function () {
//        Route::get('/', 'getListUser')->name('list-user');
//        Route::prefix('user')->group(function () {
//            Route::get('/list', 'getListUser')->name('list-user');
//            Route::get('/detail/{id}', 'viewUser')->name('detail-user');
//            Route::middleware(['productmanager','accountant','seller','sellerdepartment'])->group(function () {
//                Route::get('/add', 'addUser')->name('add-user');
//                Route::post('/add', 'createUser')->name('create-user');
//                Route::get('/edit/{id}', 'viewUserEdit')->name('edit-user');
//                Route::post('/edit/{id}', 'editUser')->name('edited-user');
//                Route::post('/delete', 'deleteUser')->name('delete-user');
//            });
//        });
//    });
});
