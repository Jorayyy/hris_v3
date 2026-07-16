<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

// Automatically redirect empty landing routes straight to the login interface
Route::get('/', function () {
    return redirect()->route('login');
});

// Universal User Session Authentication Routes (Managed by Breeze engine backend)
require __DIR__.'/auth.php';

// PROTECTED ROUTES INTERFACE CONTAINER (User MUST be authenticated to enter)
Route::middleware(['auth'])->group(function () {
    
    // 🧑‍💼 Universal Employee & Accounting Attendance Dashboard Modules
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/clock', [DashboardController::class, 'toggleClock'])->name('clock.toggle');
    Route::post('/leave', [DashboardController::class, 'storeLeave'])->name('leave.store');

    // 🔒 Core User Profile Configuration Management Endpoints
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 💰 SECURE PAYROLL GATEWAY (Accessible strictly by Super Admin and Accounting tiers)
    Route::middleware(['can:is-accounting'])->prefix('payroll')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/generate', [PayrollController::class, 'store'])->name('payroll.store');
    });

    // 👑 MANAGEMENT CONTROL PANEL (Accessible strictly by Super Admin, Admin, and HR tiers)
    Route::middleware(['can:is-admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/leave/{id}/{status}', [AdminController::class, 'updateLeave'])->name('admin.leave.update');
        Route::post('/employee/store', [AdminController::class, 'storeEmployee'])->name('admin.employee.store');
    });
});
