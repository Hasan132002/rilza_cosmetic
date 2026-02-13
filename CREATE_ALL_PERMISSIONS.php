<?php
/**
 * Create ALL Admin Permissions - Granular Control
 * This adds permissions for EVERY admin route/screen
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║     CREATING ALL ADMIN PERMISSIONS (GRANULAR)         ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// Define ALL permissions for every admin screen/route
$allPermissions = [
    // Dashboard
    'view_dashboard',
    'view_dashboard_stats',

    // Products Module
    'view_products',
    'create_products',
    'edit_products',
    'delete_products',
    'manage_product_stock',
    'view_product_details',

    // Categories Module
    'view_categories',
    'create_categories',
    'edit_categories',
    'delete_categories',

    // Orders Module
    'view_orders',
    'view_order_details',
    'create_orders',
    'edit_orders',
    'delete_orders',
    'update_order_status',
    'print_invoice',
    'cancel_orders',

    // Coupons Module
    'view_coupons',
    'create_coupons',
    'edit_coupons',
    'delete_coupons',
    'manage_coupons',

    // Flash Sales Module
    'view_flash_sales',
    'create_flash_sales',
    'edit_flash_sales',
    'delete_flash_sales',
    'manage_flash_sales',

    // Banners Module
    'view_banners',
    'create_banners',
    'edit_banners',
    'delete_banners',
    'manage_banners',

    // Pages (CMS) Module
    'view_pages',
    'create_pages',
    'edit_pages',
    'delete_pages',
    'manage_pages',

    // Blog Module
    'view_blogs',
    'create_blogs',
    'edit_blogs',
    'delete_blogs',
    'manage_blogs',
    'publish_blogs',

    // Newsletter Module
    'view_newsletter_subscribers',
    'export_newsletter_subscribers',
    'delete_newsletter_subscribers',
    'manage_email_campaigns',
    'send_newsletters',

    // Popup Campaigns Module
    'view_popup_campaigns',
    'create_popup_campaigns',
    'edit_popup_campaigns',
    'delete_popup_campaigns',
    'manage_popups',
    'toggle_popup_active',

    // Abandoned Carts Module
    'view_abandoned_carts',
    'view_abandoned_cart_details',
    'send_abandoned_cart_reminders',
    'delete_abandoned_carts',
    'manage_abandoned_carts',

    // Product Reviews Module
    'view_reviews',
    'approve_reviews',
    'reject_reviews',
    'delete_reviews',
    'manage_reviews',

    // Inventory Module
    'view_inventory_logs',
    'manage_inventory',
    'bulk_update_inventory',
    'download_inventory_template',
    'upload_inventory',

    // Reports Module
    'view_reports',
    'view_sales_report',
    'view_order_report',
    'view_product_report',
    'view_customer_report',
    'export_reports',

    // User Management Module
    'view_users',
    'create_users',
    'edit_users',
    'delete_users',
    'manage_users',

    // Role & Permission Module
    'view_roles',
    'create_roles',
    'edit_roles',
    'delete_roles',
    'manage_roles',
    'assign_permissions',
    'manage_permissions',

    // Activity Logs Module
    'view_activity_logs',
    'delete_activity_logs',
    'export_activity_logs',

    // Settings Module
    'view_settings',
    'edit_settings',
    'manage_settings',
    'manage_seo',
    'manage_social_media',
    'upload_logo',

    // Announcements Module
    'view_announcements',
    'create_announcements',
    'edit_announcements',
    'delete_announcements',
    'manage_announcements',
];

echo "Creating " . count($allPermissions) . " permissions...\n\n";

$created = 0;
$existing = 0;

foreach ($allPermissions as $permName) {
    $perm = Permission::firstOrCreate(
        ['name' => $permName],
        ['guard_name' => 'web']
    );

    if ($perm->wasRecentlyCreated) {
        echo "  ✅ Created: {$permName}\n";
        $created++;
    } else {
        $existing++;
    }
}

echo "\n📊 Results:\n";
echo "  • Created NEW: {$created}\n";
echo "  • Already existed: {$existing}\n";
echo "  • TOTAL in database: " . Permission::count() . "\n\n";

// Assign ALL permissions to super_admin role
echo "Assigning ALL permissions to super_admin role...\n";
$superAdmin = Role::where('name', 'super_admin')->first();

if ($superAdmin) {
    $superAdmin->syncPermissions(Permission::all());
    echo "✅ Super Admin now has ALL " . Permission::count() . " permissions\n\n";
} else {
    echo "❌ Super Admin role not found!\n\n";
}

// Assign selected permissions to admin role (exclude RBAC)
echo "Assigning permissions to admin role...\n";
$admin = Role::where('name', 'admin')->first();

if ($admin) {
    $adminPermissions = Permission::whereNotIn('name', [
        'manage_roles',
        'create_roles',
        'edit_roles',
        'delete_roles',
        'manage_permissions',
        'assign_permissions',
        'manage_users', // Keep view_users but not manage
        'create_users',
        'delete_users',
    ])->get();

    $admin->syncPermissions($adminPermissions);
    echo "✅ Admin role now has " . $adminPermissions->count() . " permissions\n";
    echo "   (Excluded: User/Role/Permission management)\n\n";
} else {
    echo "❌ Admin role not found!\n\n";
}

// Clear permission cache
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║            ✅ ALL PERMISSIONS CREATED! ✅              ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "📋 PERMISSION SUMMARY:\n";
echo "  • Total Permissions: " . Permission::count() . "\n";
echo "  • Super Admin has: ALL\n";
echo "  • Admin has: " . ($adminPermissions->count() ?? 0) . " (without RBAC)\n";
echo "  • Staff role: Can be customized as needed\n\n";

echo "🎯 NOW:\n";
echo "1. Login with: admin@rizla.com / password\n";
echo "2. Go to: Admin → User Management → Roles & Permissions\n";
echo "3. Customize permissions for each role\n";
echo "4. Assign/revoke specific permissions as needed\n\n";

echo "✅ Database updated successfully!\n\n";
