<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    ExpenseController,
    IncomeController,
    TransactionController,
    ReportController,
    ProfileController
};


// Auth Routes (Tanpa Login)

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout hanya bisa dilakukan oleh user yang login
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Default route
Route::get('/', function () {
    return redirect()->route('login');
});


// Protected Routes (Hanya untuk Login)

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pemasukan
    Route::resource('incomes', IncomeController::class)->except(['index', 'show']);

    // Pengeluaran
    Route::resource('expenses', ExpenseController::class)->except(['index', 'show']);

    // Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    // Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::get('/profile/export-csv', [ProfileController::class, 'exportCsv'])->name('profile.export.csv');
    Route::get('/profile/export-pdf', [ProfileController::class, 'exportPdf'])->name('profile.export.pdf');
});
