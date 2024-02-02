<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/destroy', [DashboardController::class, 'destroy'])->name('dashboard.destroy');

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');

