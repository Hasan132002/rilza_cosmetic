<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\InventoryLogController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PopupCampaignController;
use App\Http\Controllers\Admin\AbandonedCartController;
use App\Http\Controllers\Admin\BulkInventoryController;
use App\Http\Controllers\Admin\B2BApprovalController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Admin panel routes with authentication and role-based access control.
| All routes require authentication and admin/super_admin/staff roles.
|
*/

// Admin Authentication Routes (Public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// Protected Admin Routes (with activity logging)
Route::middleware(['auth', 'role:super_admin,admin,staff', 'log.activity'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class)->middleware('permission:view_categories');

    // Products
    Route::resource('products', ProductController::class)->middleware('permission:view_products');

    // Orders
    Route::middleware('permission:view_orders')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    // Coupons
    Route::resource('coupons', CouponController::class)->middleware('permission:manage_coupons');

    // Flash Sales
    Route::resource('flash-sales', FlashSaleController::class)->middleware('permission:view_products');

    // Newsletter Subscribers
    Route::prefix('newsletter-subscribers')->name('newsletter-subscribers.')->middleware('permission:view_products|manage_email_campaigns')->group(function () {
        Route::get('/', [NewsletterSubscriberController::class, 'index'])->name('index');
        Route::patch('{subscriber}/unsubscribe', [NewsletterSubscriberController::class, 'unsubscribe'])->name('unsubscribe');
        Route::patch('{subscriber}/resubscribe', [NewsletterSubscriberController::class, 'resubscribe'])->name('resubscribe');
        Route::delete('{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('destroy');
        Route::get('export', [NewsletterSubscriberController::class, 'export'])->name('export');
        Route::get('send-email-form', [NewsletterSubscriberController::class, 'sendEmailForm'])->name('send-email-form');
        Route::post('send-bulk-email', [NewsletterSubscriberController::class, 'sendBulkEmail'])->name('send-bulk-email');
    });

    // Inventory Logs
    Route::prefix('inventory-logs')->name('inventory-logs.')->middleware('permission:view_products')->group(function () {
        Route::get('/', [InventoryLogController::class, 'index'])->name('index');
        Route::get('/{product}', [InventoryLogController::class, 'show'])->name('show');
    });

    // Bulk Inventory Update
    Route::prefix('inventory')->name('inventory.')->middleware('permission:edit_products')->group(function () {
        Route::get('/bulk-update', [BulkInventoryController::class, 'index'])->name('bulk-update');
        Route::post('/bulk-upload', [BulkInventoryController::class, 'upload'])->name('bulk-upload');
        Route::get('/download-template', [BulkInventoryController::class, 'downloadTemplate'])->name('download-template');
    });

    // CMS
    Route::resource('banners', BannerController::class)->middleware('permission:manage_banners');
    Route::resource('pages', PageController::class)->middleware('permission:manage_pages');
    Route::resource('blogs', BlogController::class)->middleware('permission:manage_blogs');

    // Product Reviews
    Route::prefix('reviews')->name('reviews.')->middleware('permission:view_products')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::patch('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::patch('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // B2B Management
    Route::prefix('b2b')->name('b2b.')->middleware('permission:manage_users')->group(function () {
        Route::get('/pending', [B2BApprovalController::class, 'pending'])->name('pending');
        Route::get('/approved', [B2BApprovalController::class, 'approved'])->name('approved');
        Route::get('/rejected', [B2BApprovalController::class, 'rejected'])->name('rejected');
        Route::get('/{id}', [B2BApprovalController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [B2BApprovalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [B2BApprovalController::class, 'reject'])->name('reject');
        Route::patch('/{id}', [B2BApprovalController::class, 'update'])->name('update');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->middleware('permission:view_reports')->group(function () {
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/orders', [ReportController::class, 'orderReport'])->name('orders');
        Route::get('/products', [ReportController::class, 'productReport'])->name('products');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers');
        Route::get('/export/orders', [ReportController::class, 'exportOrders'])->name('export.orders');

        // B2B Reports (requires B2B reports permission)
        Route::middleware('permission:view_b2b_reports')->group(function () {
            Route::get('/b2b-analytics', [\App\Http\Controllers\Admin\B2BReportController::class, 'analytics'])->name('b2b-analytics');
            Route::post('/b2b-export', [\App\Http\Controllers\Admin\B2BReportController::class, 'export'])->name('b2b-export');
            Route::get('/b2b-customer-lifetime-value', [\App\Http\Controllers\Admin\B2BReportController::class, 'customerLifetimeValue'])->name('b2b-clv');
        });
    });

    // Settings
    Route::prefix('settings')->name('settings.')->middleware('permission:manage_settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/update', [SettingController::class, 'update'])->name('update');
    });

    // Translations
    Route::prefix('translations')->name('translations.')->middleware('permission:manage_settings')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\TranslationController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\TranslationController::class, 'store'])->name('store');
        Route::get('/{translation}/edit', [\App\Http\Controllers\Admin\TranslationController::class, 'edit'])->name('edit');
        Route::put('/{translation}', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('update');
        Route::delete('/{translation}', [\App\Http\Controllers\Admin\TranslationController::class, 'destroy'])->name('destroy');
        Route::post('/sync', [\App\Http\Controllers\Admin\TranslationController::class, 'sync'])->name('sync');
        Route::post('/import', [\App\Http\Controllers\Admin\TranslationController::class, 'import'])->name('import');
    });

    // Popup Campaigns
    Route::resource('popup-campaigns', PopupCampaignController::class)->middleware('permission:manage_popups');
    Route::post('popup-campaigns/{popupCampaign}/toggle', [PopupCampaignController::class, 'toggleActive'])->name('popup-campaigns.toggle')->middleware('permission:manage_popups');

    // Abandoned Carts
    Route::prefix('abandoned-carts')->name('abandoned-carts.')->middleware('permission:view_abandoned_carts|view_orders')->group(function () {
        Route::get('/', [AbandonedCartController::class, 'index'])->name('index');
        Route::get('/{abandonedCart}', [AbandonedCartController::class, 'show'])->name('show');
        Route::post('/{abandonedCart}/send-reminder', [AbandonedCartController::class, 'sendReminder'])->name('send-reminder');
        Route::delete('/{abandonedCart}', [AbandonedCartController::class, 'destroy'])->name('destroy');
    });

    // User Management
    Route::resource('users', UserController::class)->middleware('role:super_admin,admin');

    // Role & Permission Management
    Route::resource('roles', RoleController::class)->middleware('role:super_admin,admin');

    // Activity Logs
    Route::prefix('activity-logs')->name('activity-logs.')->middleware('role:super_admin,admin')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{log}', [ActivityLogController::class, 'show'])->name('show');
    });
});
