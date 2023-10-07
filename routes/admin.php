<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\ChildCategory\ChildCategoryController;
use App\Http\Controllers\Admin\SubCategory\SubCategoryController;




Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard Controller
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    // Category Controller
    Route::controller(CategoryController::class)->prefix('/category')->name('category.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/destroy{id}', 'destroy')->name('destroy');
    });
    // Sub Category Controller
    Route::controller(SubCategoryController::class)->prefix('/sub-category')->name('subCategory.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/destroy{id}', 'destroy')->name('destroy');
    });
    // Child Category Controller
    Route::controller(ChildCategoryController::class)->prefix('/child-category')->name('childCategory.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/destroy{id}', 'destroy')->name('destroy');
    });
});
