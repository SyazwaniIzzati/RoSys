<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlowerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CategoryController::class, 'customerIndex'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');


Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =========================
    // Admin 
    // =========================

    Route::get('/admin/categories', [CategoryController::class, 'index'])
        ->name('admin.categories');

    Route::post('/admin/categories', [CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])
        ->name('admin.categories.update');

    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('admin.categories.destroy');

    Route::get('/admin/flowers', [FlowerController::class, 'index'])
        ->name('admin.flowers');

    Route::get('/admin/flowers/category/{categoryId}', [FlowerController::class, 'category'])
        ->name('admin.flowers.category');
    
    Route::post('/admin/flowers', [FlowerController::class, 'store'])
        ->name('admin.flowers.store');

    Route::put('/admin/flowers/{flower}', [FlowerController::class, 'update'])
        ->name('admin.flowers.update');

    Route::delete('/admin/flowers/{flower}', [FlowerController::class, 'destroy'])
        ->name('admin.flowers.destroy');

});


require __DIR__.'/auth.php';