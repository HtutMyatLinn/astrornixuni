<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->middleware(['auth', 'admin']);
Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'admin']);
Route::get('/marketingmanager/dashboard', [App\Http\Controllers\HomeController::class, 'marketingmanager']);
Route::get('/marketingcoordinator/dashboard', [App\Http\Controllers\HomeController::class, 'marketingcoordinator']);
Route::get('/student/dashboard', [App\Http\Controllers\HomeController::class, 'student']);
