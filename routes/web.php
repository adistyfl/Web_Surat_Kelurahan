<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Letters Management
    Route::prefix('letters')->group(function () {
        Route::get('/', [LetterController::class, 'index'])->name('letters.index');
        Route::get('/create', [LetterController::class, 'create'])->name('letters.create');
        Route::post('/', [LetterController::class, 'store'])->name('letters.store');
        Route::get('/{letter}', [LetterController::class, 'show'])->name('letters.show');
        Route::get('/{letter}/edit', [LetterController::class, 'edit'])->name('letters.edit');
        Route::put('/{letter}', [LetterController::class, 'update'])->name('letters.update');
        Route::delete('/{letter}', [LetterController::class, 'destroy'])->name('letters.destroy');
        Route::get('/{letter}/download', [LetterController::class, 'download'])->name('letters.download');
    });
    
    // Categories Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    
    // About
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});