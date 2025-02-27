<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

// Primary route
Route::get('/', function () {
    return view('home');
})->name('/');

// Contribution route
Route::get('/contributions', function () {
    return view('contributions.index');
})->name('contributions');

// Faculty route
Route::get('/faculty', function () {
    return view('faculty');
})->name('faculty');

// About us route
Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

// Contact us route
Route::get('/contactus', function () {
    return view('contactus');
})->name('contactus');

// Routes that require the user to be authenticated and verified.
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile management routes.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin dashboard.
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'administrator'])->name('admin');
        Route::get('/admin/user-management', [HomeController::class, 'administratorUserManagement'])->name('admin.user-management');
        Route::get('/admin/user-management/student', [HomeController::class, 'administratorUserManagementStudent'])->name('admin.user-management.student');
        Route::get('/admin/user-management/marketing-manager', [HomeController::class, 'administratorUserManagementMarketingManager'])->name('admin.user-management.marketing-manager');
        Route::get('/admin/user-management/marketing-coordinator', [HomeController::class, 'administratorUserManagementMarketingCoordinator'])->name('admin.user-management.marketing-coordinator');
        Route::get('/admin/notifications', [HomeController::class, 'administratorNotifications'])->name('admin.notifications');
        Route::get('/admin/notifications/inquiry', [HomeController::class, 'administratorNotificationsInquiry'])->name('admin.notifications.inquiry');
        Route::get('/admin/notifications/password-reset', [HomeController::class, 'administratorNotificationsPassword'])->name('admin.notifications.password-reset');
        Route::get('/admin/notifications/unregister-user', [HomeController::class, 'administratorNotificationsUnregister'])->name('admin.notifications.unregister-user');
        Route::get('/admin/closure', [HomeController::class, 'administratorClosure'])->name('admin.closure');
        Route::get('/admin/inquiry', [HomeController::class, 'administratorInquiry'])->name('admin.inquiry');
        Route::get('/admin/edit-user-data', [HomeController::class, 'administratorEditUserData'])->name('admin.edit-user-data');

        // Role management routes.
        Route::resource('roles', RoleController::class);
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
