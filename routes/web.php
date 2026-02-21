<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\ToolController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
 Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/post', [AuthController::class, 'authenticate'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);   
        Route::resource('tools', ToolController::class);   
        Route::resource('category', AdminCategoryController::class);  
        Route::resource('borrowings', BorrowingController::class);
        Route::resource('returns', ReturnItemController::class);
    });

Route::prefix('officer')->name('officer.')->middleware(['auth', 'role:officer'])->group(function () {   
        Route::get('/dashboard', [DashboardController::class, 'officerIndex'])->name('dashboard');
        Route::get('borrowings', [BorrowingController::class, 'officerIndex'])->name('borrowings.index');
        Route::get('returns', [ReturnItemController::class, 'officerIndex'])->name('returns.index');
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
});
