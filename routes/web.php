<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Primary route using AuthenticatedSessionController to show the login view.
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

// Authentication routes.
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Routes that require the user to be authenticated and verified.
Route::middleware(['auth', 'verified'])->group(function () {
    // Default dashboard (if needed)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile management routes.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin dashboard.
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    });

    // Marketing Manager dashboard.
    Route::middleware('marketingmanager')->group(function () {
        Route::get('/marketingmanager/dashboard', [HomeController::class, 'marketingmanager'])->name('marketingmanager.dashboard');
    });

    // Marketing Coordinator dashboard.
    Route::middleware('marketingcoordinator')->group(function () {
        Route::get('/marketingcoordinator/dashboard', [HomeController::class, 'marketingcoordinator'])->name('marketingcoordinator.dashboard');
    });

    // Student dashboard.
    Route::middleware('student')->group(function () {
        Route::get('/student/dashboard', [HomeController::class, 'student'])->name('student.dashboard');
    });
});

// Include additional authentication routes (if any).
require __DIR__ . '/auth.php';
