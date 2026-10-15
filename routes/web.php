<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;

// Route customer publik
Route::get('/customer', [OrderController::class, 'index'])->name('customer.index');
Route::post('/customer/checkout', [OrderController::class, 'store'])->name('customer.checkout');

// Route Dashboard Admin (mendukung akses /admin/dashboard maupun /dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/dashboard', [OrderController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Master Data Event
    Route::resource('events', EventController::class);

    // Update status pesanan di dashboard
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateDashboard'])->name('admin.orders.updateStatus');
});

require __DIR__.'/auth.php';