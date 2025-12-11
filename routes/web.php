<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\DeviceIssueCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceIssueController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\JobCardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobsListController;
use App\Http\Controllers\NotificationController;



Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    // Category routes - admin only
    Route::resource('categories', CategoryController::class)
        ->middleware('can:viewAny,App\Models\Category');
    
    // Other protected routes...
});


Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);


Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::resource('users', UserController::class);
});


Route::post('/logout', [logoutController::class, 'logout'])->name('logout');


// Device routes with policy-based authorization
Route::middleware(['auth', 'can:manage-devices'])->group(function () {
    Route::resource('devices', DeviceController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('device_issues', DeviceIssueController::class);
});


//routes for assigning issues to devices
Route::get('/devices/{device}/assign-issues', [DeviceController::class, 'assignIssues'])->name('devices.assign-issues');
Route::post('/devices/{device}/assign-issues', [DeviceController::class, 'storeAssignedIssues'])->name('devices.store-assigned-issues');


Route::middleware(['auth'])->group(function () {
    // Category routes - admin only
    Route::resource('issueCategories', DeviceIssueCategoryController::class)
        ->middleware('can:viewAny,App\Models\issueCategory');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/service-requests/select-device', [ServiceRequestController::class, 'selectDevice'])->name('service-requests.select-device');
    Route::get('/service-requests/{device}/select-issues', [ServiceRequestController::class, 'selectIssues'])->name('service-requests.select-issues');
    Route::post('/service-requests/store', [ServiceRequestController::class, 'store'])->name('service-requests.store');

    Route::get('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'show'])
     ->name('service-requests.show');
     // Route::post('/service-requests/{device}/preview-quote', [ServiceRequestController::class, 'previewQuote'])->name('service-requests.preview-quote');
    // Route::get('/service-requests/download-quote', [ServiceRequestController::class, 'downloadQuote'])->name('service-requests.download-quote');
});


// routes for helpdesk role
Route::middleware(['auth'])->group(function () {
    Route::get('/JobCards', [JobCardController::class, 'index'])->name('JobCard.index');
    Route::get('/JobCards/{id}', [JobCardController::class, 'show'])->name('JobCard.show');
    Route::post('/JobCards/{id}/update-status', [JobCardController::class, 'updateStatus'])->name('JobCard.update-status');
    Route::post('/JobCards/{id}/assign-technician', [JobCardController::class, 'assignTechnician'])->name('JobCard.assign-technician');
    Route::post('/job-cards/{id}/sent-back', [JobCardController::class, 'sentBack'])->name('JobCard.sent-back');


    Route::post('/job-cards/{id}/reassign-technician', [JobCardController::class, 'reassignTechnician'])->name('JobCard.reassign-technician');
    Route::post('/job-cards/{id}/archive', [JobCardController::class, 'archive'])->name('JobCard.archive');

    Route::post('/job-cards/{id}/additional-fees', [JobCardController::class, 'addAdditionalFees'])
    ->name('JobCard.add-additional-fees');

    Route::post('/job-cards/{id}/update-payment', [JobCardController::class, 'updatePayment'])
    ->name('JobCard.update-payment');

    //Route::get('/job-cards/list', [JobsListController::class, 'index'])->name('JobCard.list');
});


//routes for setting consultation fee
// Route::middleware(['auth', 'role:admin'])->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});



// Email Verification Routes
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify');

Route::post('/email/verify/resend', [EmailVerificationController::class, 'resend'])
    ->name('verification.resend');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');


Route::get('/verification-help', function () {
    return view('auth.verification-help');
})->name('verification.help');

// Password Change Routes (for temporary passwords)
// Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change');
// Route::post('/password/change', [UserController::class, 'updatePassword'])->name('password.update');



// Dashboard Routes
Route::get('/dashboard/welcome', [DashboardController::class, 'welcome'])->name('dashboard.welcome');


Route::get('/job-list', [JobCardController::class, 'jobList'])->name('job.list');

// routes/web.php
Route::middleware(['auth'])->group(function() {
    Route::get('/service-history', [App\Http\Controllers\ServiceRequestController::class, 'history'])
         ->name('service-requests.history');
});

Route::get('/notifications/read/{id}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])
    ->name('notifications.read');

Route::get('/notifications/mark-all-read', 
    [App\Http\Controllers\NotificationController::class, 'markAllRead']
)->name('notifications.markAllRead');


