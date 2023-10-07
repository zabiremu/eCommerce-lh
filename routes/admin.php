<?php

use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;




Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard Controller
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    // Category Controller
    Route::controller(CategoryController::class)->prefix('/category')->name('category.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::get('/', 'destroy')->name('destroy');
    });
});
