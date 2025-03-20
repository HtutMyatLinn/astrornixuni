<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContributionCategoryController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\MarketingCoordinatorControllerr;
use App\Http\Controllers\MarketingManagerController;
use App\Http\Controllers\MostActiveUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UnassignedUserController;
use App\Http\Middleware\MarketingCoordinatorMiddleware;
use App\Http\Middleware\TrackBrowser;
use Illuminate\Support\Facades\Route;

// Primary route
Route::get('/', [ContributionController::class, 'guest_index'])->name('/')->middleware(TrackBrowser::class);

// Contribution route
Route::get('/contributions', [ContributionController::class, 'contribution_index'])->name('contributions');
Route::get('/student/contribution-detail/{contribution}', [ContributionController::class, 'show'])->name('student.contribution-detail');
Route::get('/student/contributions/search', [ContributionController::class, 'search'])->name('student.contribution.search');

Route::resource('student/contributions/comment', CommentController::class);
Route::patch('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

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

// Contact us data store route
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');

// Routes that require the user to be authenticated and verified.
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile management routes.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin dashboard.
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'administrator'])->name('admin')->middleware(TrackBrowser::class);

        // Account setting routes
        Route::get('/admin/account-setting', [AdminController::class, 'accountSetting'])->name('admin.account-setting');
        Route::post('/admin/update-account-setting/{id}', [AdminController::class, 'updateAccountSetting'])->name('admin.update-account-setting');
        Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change-password');

        Route::get('/data-management/contribution-category', [HomeController::class, 'contributionCategory'])->name('data-management.contribution-category');
        Route::get('/admin/notifications/password-reset', [HomeController::class, 'administratorNotificationsPassword'])->name('admin.notifications.password-reset');
        Route::post('/admin/reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset-password');

        // Inquiry routes
        Route::get('/admin/notifications/inquiry', [InquiryController::class, 'index'])
            ->name('admin.notifications.inquiry');
        Route::put('/admin/notifications/inquiry/{id}', [InquiryController::class, 'update'])
            ->name('admin.notifications.inquiry.update');

        Route::get('/admin/edit-user-data/{id}', [HomeController::class, 'administratorEditUserData'])->name('admin.edit-user-data');
        Route::post('/admin/update-user-data/{id}', [HomeController::class, 'administratorUpdateUserData'])->name('admin.update-user-data');

        // Academic year and Intake routes
        Route::resource('admin/academic-years', AcademicYearController::class);
        Route::get('/academic-years/search', [AcademicYearController::class, 'search'])->name('admin.academic-years.search');
        Route::get('/academic-years', [AcademicYearController::class, 'index'])->name('academic-years.index');

        //Intake routes
        Route::post('/admin/intakes', [AcademicYearController::class, 'intake_store'])->name('admin.intakes');
        Route::get('/intakes/search', [AcademicYearController::class, 'intake_search'])->name('admin.intakes.search');
        Route::put('/admin/intakes/{id}', [IntakeController::class, 'update'])->name('intakes.update');

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

        // Faculty Geust routes
        Route::get('/admin/user-management/faculty-guest', [AdminController::class, 'faculty_guest_index'])->name('admin.user-management.faculty-guest');
        Route::get('/admin/user-management/faculty-guest/search', [AdminController::class, 'faculty_guest_search'])->name('admin.user-management.faculty-guest.search');

        // Marketing Coordinator management routes.
        Route::get('/admin/user-management/marketing-coordinator', [MarketingCoordinatorControllerr::class, 'index'])->name('admin.user-management.marketing-coordinator');
        Route::get('/admin/user-management/marketing-coordinator/search', [MarketingCoordinatorControllerr::class, 'search'])->name('admin.user-management.marketing-coordinator.search');

        // Marketing Manager management routes.
        Route::get('/admin/user-management/marketing-manager', [MarketingManagerController::class, 'index'])->name('admin.user-management.marketing-manager');
        Route::get('/admin/user-management/marketing-manager/search', [MarketingManagerController::class, 'search'])->name('admin.user-management.marketing-manager.search');

        // Student management routes.
        Route::get('/admin/user-management/student', [StudentController::class, 'index'])->name('admin.user-management.student');
        Route::get('/admin/user-management/student/search', [StudentController::class, 'search'])->name('admin.user-management.student.search');

        // Most active users routes
        Route::get('/admin/user-management/most-active-user', [MostActiveUserController::class, 'index'])->name('admin.user-management.most-active-user');
        Route::get('/admin/user-management/mostactiveuser/search', [MostActiveUserController::class, 'search'])->name('admin.user-management.mostactiveuser.search');

        //Report routes
        Route::get('/admin/reports', [AdminController::class, 'report_index'])->name('admin.reports');
    });

    // Marketing Manager dashboard.
    Route::middleware('marketingmanager')->group(function () {
        Route::get('/marketingmanager/dashboard', [HomeController::class, 'marketingmanager'])->name('marketingmanager.dashboard')->middleware(TrackBrowser::class);
        Route::get('/marketingmanager/account-setting', [HomeController::class, 'marketingmanagerAccountSetting'])->name('marketingmanager.account-setting');

        Route::get('/marketingmanager/published-contribution', [HomeController::class, 'marketingmanagerPublishedContribution'])
            ->name('marketingmanager.published-contribution');

        Route::get('/download-multiple-contributions', [HomeController::class, 'downloadMultipleContributions'])
            ->name('marketingmanager.downloadMultipleContributions');
        Route::get('/marketingmanager/publishedcontributionviewdetail/{id}', [HomeController::class, 'marketingmanagerPublishedContributionViewDetail'])
            ->name('marketingmanager.publishedcontributionviewdetail');

        Route::get('/marketingmanager/download-contribution', [HomeController::class, 'marketingmanagerDownloadContribution'])->name('marketingmanager.download-contribution');
        Route::get('/marketingmanager/report', [HomeController::class, 'marketingmanagerReport'])->name('marketingmanager.report');
        Route::get('/marketingmanager/notifications', [HomeController::class, 'marketingmanagerNotifation'])->name('marketingmanager.notifications');
    });

    // Marketing Coordinator dashboard.
    Route::middleware('marketingcoordinator')->group(function () {
        Route::get('/marketingcoordinator/dashboard', [HomeController::class, 'marketingcoordinator'])->name('marketingcoordinator.dashboard')->middleware(TrackBrowser::class);

        Route::get('/marketingcoordinator/account-setting', [HomeController::class, 'marketingcoordinatorAccountSetting'])->name('marketingcoordinator.account-setting');

        Route::get('/marketingcoordinator/guest-management', [HomeController::class, 'marketingcoordinatorGuestManagement'])->name('marketingcoordinator.guest-management');

        Route::get('/marketingcoordinator/student-management', [HomeController::class, 'marketingcoordinatorStudentManagement'])->name('marketingcoordinator.student-management');

        Route::get('/marketingcoordinator/edit-user-data/{id}', [HomeController::class, 'marketingcoordinatorEditUserData'])->name('marketingcoordinator.edit-user-data');

        Route::get('/marketingcoordinator/submission-management', [HomeController::class, 'marketingcoordinatorSubmissionManagement'])->name('marketingcoordinator.submission-management');

        Route::get('/marketingcoordinator/submission-management/view-detail-contribution/{id}', [ContributionController::class, 'viewDetail'])->name('marketingcoordinator.submission-management.view-detail-contribution');

        Route::post('/marketingcoordinator/submission-management/update-status/{id}', [ContributionController::class, 'updateStatus'])->name('marketingcoordinator.submission-management.update-status');

        Route::post('/marketingcoordinator/submission-management/publish-contribution/{id}', [ContributionController::class, 'publishContribution'])->name('marketingcoordinator.submission-management.publish-contribution');

        Route::get('/marketingcoordinator/submission-management/feedback/{id}', [ContributionController::class, 'showFeedbackForm'])->name('marketingcoordinator.submission-management.feedback');

        Route::post('/marketingcoordinator/submit-feedback/{id}', [ContributionController::class, 'submitFeedback'])->name('marketingcoordinator.submit-feedback');

        Route::get('/marketingcoordinator/provide-feedback', [HomeController::class, 'marketingcoordinatorProvideFeedBack'])->name('marketingcoordinator.provide-feedback');


        Route::get('/marketingcoordinator/selected-contributions', [ContributionController::class, 'selectedContributions'])->name('marketingcoordinator.selected-contributions');

        Route::get('/marketingcoordinator/published-contribution', [HomeController::class, 'marketingcoordinatorPublishedContribution'])->name('marketingcoordinator.published-contribution');
        Route::get('/marketingcoordinator/notifications', [ContributionController::class, 'marketingcoordinatorNotifications'])->name('marketingcoordinator.notifications');

        Route::get('/marketingcoordinator/report', [ContributionController::class, 'reports'])->name('marketingcoordinator.report');
    });

    // Student dashboard.
    Route::middleware('student')->group(function () {
        Route::get('/student/dashboard', [HomeController::class, 'student'])->name('student.dashboard')->middleware(TrackBrowser::class);
        Route::resource('/student/upload_contribution', ContributionController::class);
        Route::get('re_upload_contribution', function () {
            return view('student.re_upload_contribution');
        })->name('re_upload_contribution');
        Route::put('/profile/update', [StudentController::class, 'update'])->name('profile.update');
    });
});


// Include additional authentication routes (if any).
require __DIR__ . '/auth.php';
