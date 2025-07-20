<?php

use App\Http\Controllers\Auth\logoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;



//routes for category
// Route::resource('categories', CategoryController::class);

//routes for product
// Route::resource('products', ProductController::class);

//routes for user
// Route::resource('users', UserController::class)->except(['show']);
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('users', UserController::class)->except(['show']);
//     Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
// });


Route::middleware(['auth'])->group(function () {

      Route::get('/', function () {
        return view('dashboard');
    });
    
    
    // // Category routes 
    // Route::resource('categories', CategoryController::class);

        // Product routes
    // Route::resource('products', ProductController::class);
    
});

Route::middleware(['auth', 'can:manage-products'])->group(function () {
    Route::resource('products', ProductController::class);
});


Route::middleware(['auth'])->group(function () {
    // Category routes - admin only
    Route::resource('categories', CategoryController::class)
        ->middleware('can:viewAny,App\Models\Category');
    
    // Other protected routes...
});


Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);



// Route::middleware(['auth'])->group(function () {
//     // User management routes
//     Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:view-users');
//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:create-users');
//     Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('can:create-users');
//     Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('can:view-user');
//     Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:edit-user');
//     Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('can:edit-user');
//     Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('can:delete-users');
// });


Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
});


// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/daily', [ReportController::class, 'dailySales']);
    Route::get('/reports/sales/export', [ReportController::class, 'exportSales']);
});


//Route::post('/create', [UserController::class, 'create'])->name('create')->middleware('can:create-users');

Route::post('/logout', [logoutController::class, 'logout'])->name('logout');


