<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\PlanController;
use App\Http\Controllers\SuperAdmin\SubscriptionController as SuperAdminSubscriptionController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\ReportController as SuperAdminReportController;
use App\Http\Controllers\SuperAdmin\SettingController as SuperAdminSettingController;
use App\Http\Controllers\SuperAdmin\BusinessTypeController;
use App\Http\Controllers\SuperAdmin\AddonController;

use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\ProductController;
use App\Http\Controllers\Company\BranchController;
use App\Http\Controllers\Company\CategoryController;
use App\Http\Controllers\Company\InventoryController as CompanyInventoryController;
use App\Http\Controllers\Company\PurchaseController as CompanyPurchaseController;
use App\Http\Controllers\Company\SaleController as CompanySaleController;
use App\Http\Controllers\Company\UserController as CompanyUserController;
use App\Http\Controllers\Company\ReportController as CompanyReportController;
use App\Http\Controllers\Company\SubscriptionController as CompanySubscriptionController;
use App\Http\Controllers\Company\SettingController as CompanySettingController;

use App\Http\Controllers\Branch\DashboardController as BranchDashboardController;
use App\Http\Controllers\Branch\PosController;
use App\Http\Controllers\Branch\SaleController as BranchSaleController;
use App\Http\Controllers\Branch\InventoryController as BranchInventoryController;
use App\Http\Controllers\Branch\PurchaseController as BranchPurchaseController;
use App\Http\Controllers\Branch\ReportController as BranchReportController;
use App\Http\Controllers\Branch\ShiftController;
use App\Http\Controllers\Branch\SortingController;
use App\Http\Controllers\Branch\StockAdjustmentController;
use App\Http\Controllers\Branch\CustomerController as BranchCustomerController;

// ============================================================
// Public Welcome Page
// ============================================================
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// ============================================================
// SUPER ADMIN ROUTES
// Role: Super Admin only
// Middleware: auth + role:Super Admin + tenant access
// ============================================================
Route::prefix('superadmin')
    ->middleware(['auth', 'role:Super Admin'])
    ->name('superadmin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Company Management
        Route::get('/companies', [CompanyController::class, 'index'])
            ->name('companies.index');

        // Subscription Plans
        Route::get('/plans', [PlanController::class, 'index'])
            ->name('plans.index');

        // Subscriptions
        Route::get('/subscriptions', [SuperAdminSubscriptionController::class, 'index'])
            ->name('subscriptions.index');

        // Addons
        Route::get('/addons', [AddonController::class, 'index'])
            ->name('addons.index');

        // Business Types
        Route::get('/business-types', [BusinessTypeController::class, 'index'])
            ->name('business-types.index');

        // User Management
        Route::get('/users', [SuperAdminUserController::class, 'index'])
            ->name('users.index');

        // Role & Permission Management
        Route::get('/roles', [RoleController::class, 'index'])
            ->name('roles.index');

        // Reports
        Route::get('/reports', [SuperAdminReportController::class, 'index'])
            ->name('reports.index');

        // System Logs
        Route::get('/system/logs', function () {
            return Inertia::render('SuperAdmin/SystemLogs');
        })->name('system.logs');

        // Settings
        Route::get('/settings/general', [SuperAdminSettingController::class, 'index'])
            ->name('settings.general');
    });

// ============================================================
// COMPANY ADMIN ROUTES
// Role: Company Admin only
// Middleware: auth + role:Company Admin + tenant isolation
// ============================================================
Route::prefix('company')
    ->middleware(['auth', 'role:Company Admin', 'tenant'])
    ->name('company.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])
            ->name('dashboard');

        // Branch Management
        Route::get('/branches', [BranchController::class, 'index'])
            ->name('branches.index');

        // Product Management (full CRUD)
        Route::resource('products', ProductController::class);

        // Category Management
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        // Inventory
        Route::get('/inventory/low-stock', [CompanyInventoryController::class, 'lowStock'])
            ->name('inventory.low-stock');
        Route::get('/inventory/stock-adjust', [CompanyInventoryController::class, 'stockAdjust'])
            ->name('inventory.stock-adjust');

        // Purchases
        Route::get('/purchases', [CompanyPurchaseController::class, 'index'])
            ->name('purchases.index');

        // Sales
        Route::get('/sales', [CompanySaleController::class, 'index'])
            ->name('sales.index');

        // User Management (company-scoped)
        Route::get('/users', [CompanyUserController::class, 'index'])
            ->name('users.index');

        // Reports
        Route::get('/reports/daily-sales', [CompanyReportController::class, 'dailySales'])
            ->name('reports.daily-sales');
        Route::get('/reports/stock', [CompanyReportController::class, 'stock'])
            ->name('reports.stock');

        // Subscription
        Route::get('/subscription', [CompanySubscriptionController::class, 'index'])
            ->name('subscription.index');

        // Settings
        Route::get('/settings/profile', [CompanySettingController::class, 'profile'])
            ->name('settings.profile');
    });

// ============================================================
// BRANCH ROUTES
// Roles: Manager OR Salesman
// Middleware: auth + role:Manager|Salesman + tenant isolation
// ============================================================
Route::prefix('branch')
    ->middleware(['auth', 'role:Manager|Salesman', 'tenant'])
    ->name('branch.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [BranchDashboardController::class, 'index'])
            ->name('dashboard');

        // --------------------------------------------------
        // POS Terminal Routes
        // --------------------------------------------------

        // 1. Load the POS terminal page
        Route::get('/pos', [PosController::class, 'index'])
            ->name('pos');

        // 2. AJAX: Search product by barcode, SKU, or name
        //    Called by the POS frontend via Axios GET request.
        Route::get('/pos/search', [PosController::class, 'search'])
            ->name('pos.search');

        // 3. POST: Process checkout — deduct stock, create Sale + SaleItems + StockMovements
        //    Called by the POS frontend form submission.
        Route::post('/pos/checkout', [PosController::class, 'checkout'])
            ->name('pos.checkout');

        // 4. GET: Print/view invoice after a successful sale
        //    Uses route model binding: {sale} resolves to a Sale instance.
        Route::get('/pos/invoice/{sale}', [PosController::class, 'printInvoice'])
            ->name('pos.invoice-print');

        // --------------------------------------------------
        // Inventory (Branch-level)
        // --------------------------------------------------
        Route::get('/inventory/receive-sort', [SortingController::class, 'index'])
            ->name('inventory.receive-sort');
        Route::get('/inventory/sorting-history', [SortingController::class, 'history'])
            ->name('inventory.sorting-history');
        Route::get('/inventory/stock-adjustment', [StockAdjustmentController::class, 'index'])
            ->name('inventory.stock-adjustment');

        // --------------------------------------------------
        // Purchases (Branch-level receiving)
        // --------------------------------------------------
        Route::get('/purchases', [BranchPurchaseController::class, 'index'])
            ->name('purchases.index');

        // --------------------------------------------------
        // Sales History
        // --------------------------------------------------
        Route::get('/sales', [BranchSaleController::class, 'index'])
            ->name('sales.index');

        // --------------------------------------------------
        // Customers
        // --------------------------------------------------
        Route::get('/customers', [BranchCustomerController::class, 'index'])
            ->name('customers.index');

        // --------------------------------------------------
        // Reports
        // --------------------------------------------------
        Route::get('/reports', [BranchReportController::class, 'index'])
            ->name('reports.index');

        // --------------------------------------------------
        // Shift Management
        // --------------------------------------------------
        Route::get('/shift/open', [ShiftController::class, 'open'])
            ->name('shift.open');
        Route::post('/shift/start', [ShiftController::class, 'start'])
            ->name('shift.start');
        Route::post('/shift/close', [ShiftController::class, 'close'])
            ->name('shift.close');
    });

// ============================================================
// Auth Routes (login, register, password reset, etc.)
// ============================================================
require __DIR__ . '/auth.php';
