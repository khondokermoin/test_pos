<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Branch\DashboardController as BranchDashboardController;
use App\Http\Controllers\Branch\PosController;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware(['auth'])->group(function () {
    // Super Admin Routes
    Route::prefix('superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');
        Route::get('/companies', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/plans', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/subscriptions', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/addons', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/business-types', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/users', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/roles', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/reports', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/system/logs', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
        Route::get('/settings/general', function () {
            return Inertia::render('SuperAdmin/Dashboard');
        });
    });

    // Company Admin Routes
    Route::prefix('company')->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
        Route::get('/branches', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/products', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/categories', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/inventory/low-stock', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/inventory/stock_adjust', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/purchases', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/sales', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/users', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/reports/daily-sales', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/reports/stock', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/subscription', function () {
            return Inertia::render('Company/Dashboard');
        });
        Route::get('/settings/profile', function () {
            return Inertia::render('Company/Dashboard');
        });
    });

    // Branch Routes
    Route::prefix('branch')->group(function () {
        Route::get('/dashboard', [BranchDashboardController::class, 'index'])->name('branch.dashboard');
        Route::get('/pos', [PosController::class, 'index'])->name('branch.pos');
        Route::get('/inventory/receive-sort', function () {
            return Inertia::render('Branch/Dashboard');
        });
        Route::get('/inventory/sorting-history', function () {
            return Inertia::render('Branch/Dashboard');
        });
    });
});

require __DIR__.'/auth.php';


