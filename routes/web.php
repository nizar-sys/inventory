<?php

use App\Http\Controllers\Console\CategoryController;
use App\Http\Controllers\Console\PermissionController;
use App\Http\Controllers\Console\ProductController;
use App\Http\Controllers\Console\ProductStockController;
use App\Http\Controllers\Console\RoleController;
use App\Http\Controllers\Console\StockOpnameController;
use App\Http\Controllers\Console\SupplierController;
use App\Http\Controllers\Console\UserController;
use App\Http\Controllers\Console\WarehouseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\StockOpname;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('console')->middleware(['auth', 'verified'])->group(function () {

    Route::middleware('role:Administrator')->group(function () {
        Route::resource('permissions', PermissionController::class);
        Route::resource('roles', RoleController::class);
        Route::patch('/users/profile/{id}', [UserController::class, 'updateDetail'])->name('users.profile.update');
        Route::resource('users', UserController::class);
        Route::resource('warehouses', WarehouseController::class);
    });

    Route::resource('suppliers', SupplierController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stocks', ProductStockController::class);
    Route::resource('stock-opnames', StockOpnameController::class);
});
