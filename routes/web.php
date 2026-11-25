<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'POS Barokah Mart - toko kelontong yang menyediakan kebutuhan sembako, minuman, makanan ringan, dan kebutuhan rumah tangga dengan harga terjangkau.';
})->name('about');

// Rute Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Rute Terproteksi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('report.sales');
        Route::get('/reports/sales/export', [ReportController::class, 'export'])->name('report.export');
        Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
        Route::resource('suppliers', SupplierController::class)->except('show');
        Route::resource('purchase-orders', PurchaseOrderController::class)->except(['edit', 'update']);
        Route::post('purchase-orders/{purchase_order}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');
    });

    // Admin dan Kasir
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
        Route::get('/pos/riwayat', [PosController::class, 'history'])->name('pos.history');
        Route::get('/pos/{transaction}/struk', [PosController::class, 'struk'])->name('pos.struk');
    });
});
