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
        Route::post('borrowings/{id}', [BorrowingController::class, 'officerApprove'])->name('borrowings.approve');
        Route::post('borrowings/{id}/reject', [BorrowingController::class, 'officerReject'])->name('borrowings.reject');
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'userIndex'])->name('dashboard');
        Route::get('/tools', [UserController::class, 'borrowingsList'])->name('borrowings_list');
        Route::get('/tools/create', [UserController::class, 'borrowingscreate'])->name('borrowings_create');
        Route::post('/tools/store', [UserController::class, 'borrowingsstore'])->name('borrowings_store');
            
        // Borrowings routes
        Route::get('/borrowings', [UserController::class, 'borrowingsList'])->name('borrowings.list');
        Route::get('/borrowings/{id}', [UserController::class, 'borrowingShow'])->name('borrowings.show');
        Route::delete('/borrowings/{id}', [UserController::class, 'borrowingCancel'])->name('borrowings.cancel');
        Route::post('/borrowings/{id}/return', [UserController::class, 'borrowingReturn'])->name('borrowings.return');
});
