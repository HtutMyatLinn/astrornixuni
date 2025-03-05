<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContributionCategoryController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\MarketingCoordinatorControllerr;
use App\Http\Controllers\MarketingManagerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UnassignedUserController;
use App\Http\Middleware\MarketingCoordinatorMiddleware;
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

Route::get('/student/contribution-detail', function () {
    return view('contribution-detail');
})->name('student.contribution-detail');

// Routes that require the user to be authenticated and verified.
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile management routes.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin dashboard.
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'administrator'])->name('admin');
        Route::get('/admin/account-setting', [HomeController::class, 'adminAccountSetting'])->name('admin.account-setting');
        Route::get('/data-management/contribution-category', [HomeController::class, 'contributionCategory'])->name('data-management.contribution-category');
        Route::get('/admin/notifications', [HomeController::class, 'administratorNotifications'])->name('admin.notifications');
        Route::get('/admin/notifications/inquiry', [HomeController::class, 'administratorNotificationsInquiry'])->name('admin.notifications.inquiry');
        Route::get('/admin/notifications/password-reset', [HomeController::class, 'administratorNotificationsPassword'])->name('admin.notifications.password-reset');
        Route::get('/admin/inquiry', [HomeController::class, 'administratorInquiry'])->name('admin.inquiry');
        // Route::get('/admin/edit-user-data', [HomeController::class, 'administratorEditUserData'])->name('admin.edit-user-data');
        Route::get('/admin/edit-user-data/{id}', [HomeController::class, 'administratorEditUserData'])->name('admin.edit-user-data');
        Route::post('/admin/update-user-data/{id}', [HomeController::class, 'administratorUpdateUserData'])->name('admin.update-user-data');

        // Academic year and Intake routes
        Route::resource('admin/academic-years', AcademicYearController::class);
        Route::get('/academic-years/search', [AcademicYearController::class, 'search'])->name('admin.academic-years.search');

        //Intake routes
        Route::post('/admin/intakes', [AcademicYearController::class, 'intake_store'])->name('admin.intakes');
        Route::get('/intakes/search', [AcademicYearController::class, 'intake_search'])->name('admin.intakes.search');

        // Role management routes.
        Route::resource('data-management/roles', RoleController::class);
        Route::get('/admin/roles/search', [RoleController::class, 'search'])->name('admin.roles.search');

        // Contribution Category management routes.
        Route::resource('/data-management/contribution-category', ContributionCategoryController::class);
        Route::get('/admin/contribution-categories/search', [ContributionCategoryController::class, 'search'])->name('admin.contribution_categories.search');

        // Faculty management routes.
        Route::resource('/data-management/faculty', FacultyController::class);
        Route::get('/faculty/search', [FacultyController::class, 'search'])->name('data-management.faculty.search');

        // Unassigned user management routes.
        Route::get('/admin/notifications/unregister-user', [UnassignedUserController::class, 'index'])->name('admin.notifications.unregister-user');
        Route::get('/admin/notifications/unregister-user/search', [UnassignedUserController::class, 'search'])->name('admin.notifications.unregister-user.search');

        // Admin management routes.
        Route::get('/admin/user-management', [AdminController::class, 'index'])->name('admin.user-management');
        Route::get('/admin/user-management/search', [AdminController::class, 'search'])->name('admin.user-management.search');
        Route::get('/admin/user-management/sort', [AdminController::class, 'sortByLastLoginDate'])->name('admin.user-management.sort');

        // Marketing Coordinator management routes.
        Route::get('/admin/user-management/marketing-coordinator', [MarketingCoordinatorControllerr::class, 'index'])->name('admin.user-management.marketing-coordinator');
        Route::get('/admin/user-management/marketing-coordinator/search', [MarketingCoordinatorControllerr::class, 'search'])->name('admin.user-management.marketing-coordinator.search');

        // Marketing Manager management routes.
        Route::get('/admin/user-management/marketing-manager', [MarketingManagerController::class, 'index'])->name('admin.user-management.marketing-manager');
        Route::get('/admin/user-management/marketing-manager/search', [MarketingManagerController::class, 'search'])->name('admin.user-management.marketing-manager.search');

        // Student management routes.
        Route::get('/admin/user-management/student', [StudentController::class, 'index'])->name('admin.user-management.student');
        Route::get('/admin/user-management/student/search', [StudentController::class, 'search'])->name('admin.user-management.student.search');
    });

    // Marketing Manager dashboard.
    Route::middleware('marketingmanager')->group(function () {
        Route::get('/marketingmanager/dashboard', [HomeController::class, 'marketingmanager'])->name('marketingmanager.dashboard');
    });

    // Marketing Coordinator dashboard.
    Route::middleware('marketingcoordinator')->group(function () {
        Route::get('/marketingcoordinator/dashboard', [HomeController::class, 'marketingcoordinator'])->name('marketingcoordinator.dashboard');

        Route::get('/marketingcoordinator/account-setting', [HomeController::class, 'marketingcoordinatorAccountSetting'])->name('marketingcoordinator.account-setting');

        Route::get('/marketingcoordinator/guest-management', [HomeController::class, 'marketingcoordinatorGuestManagement'])->name('marketingcoordinator.guest-management');

        Route::get('/marketingcoordinator/submission-management', [HomeController::class, 'marketingcoordinatorSubmissionManagement'])->name('marketingcoordinator.submission-management');

        Route::get('/marketingcoordinator/submission-management/view-detail-contribution', [HomeController::class, 'marketingcoordinatorSubmissionManagementViewDetailContribution'])->name('marketingcoordinator.submission-management.view-detail-contribution');

        Route::get('/marketingcoordinator/provide-feedback', [HomeController::class, 'marketingcoordinatorProvideFeedBack'])->name('marketingcoordinator.provide-feedback');
        Route::get('/marketingcoordinator/published-contribution', [HomeController::class, 'marketingcoordinatorPublishedContribution'])->name('marketingcoordinator.published-contribution');
        Route::get('/marketingcoordinator/notifications', [HomeController::class, 'marketingcoordinatorNotifications'])->name('marketingcoordinator.notifications');
    });

    // Student dashboard.
    Route::middleware('student')->group(function () {
        Route::get('/student/dashboard', [HomeController::class, 'student'])->name('student.dashboard');
        Route::get('/student/upload_contribution', function () {
            return view('upload_contribution');
        })->name('student.upload_contribution');
    });
});


// Include additional authentication routes (if any).
require __DIR__ . '/auth.php';
