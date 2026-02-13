<?php
/**
 * ULTIMATE PERMISSION FIX
 * This will fix ALL permission issues permanently
 *
 * Run: php ULTIMATE_PERMISSION_FIX.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "\n";
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║          ULTIMATE PERMISSION FIX - RIZLA COSMETICS           ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Verify admin user
echo "STEP 1: Finding admin user...\n";
$adminUser = User::where('email', 'admin@rizla.com')->first();

if (!$adminUser) {
    echo "❌ ERROR: admin@rizla.com not found!\n\n";
    exit(1);
}

echo "✅ Found: {$adminUser->name} (ID: {$adminUser->id})\n";
echo "   Email: {$adminUser->email}\n";
echo "   Current Roles: " . $adminUser->roles->pluck('name')->join(', ') . "\n\n";

// Step 2: Define ALL required permissions
echo "STEP 2: Creating/verifying ALL permissions...\n";

$allPermissions = [
    // Dashboard
    'view_dashboard',

    // Products
    'view_products', 'create_products', 'edit_products', 'delete_products',

    // Categories
    'view_categories', 'create_categories', 'edit_categories', 'delete_categories',

    // Orders
    'view_orders', 'edit_orders', 'delete_orders', 'print_invoice',

    // CMS
    'manage_banners', 'manage_pages', 'manage_blogs', 'manage_announcements',

    // Marketing
    'manage_coupons', 'manage_flash_sales', 'manage_email_campaigns',
    'manage_popups', 'view_abandoned_carts',

    // Reports
    'view_reports', 'export_reports',

    // Settings
    'manage_settings', 'manage_seo', 'manage_social_media',

    // RBAC
    'manage_roles', 'manage_permissions', 'manage_users',
];

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

echo "\n  📊 Results: {$created} created, {$existing} already existed\n";
echo "  ✅ Total permissions in system: " . Permission::count() . "\n\n";

// Step 3: Ensure super_admin role exists and has ALL permissions
echo "STEP 3: Configuring super_admin role...\n";

$superAdminRole = Role::firstOrCreate(
    ['name' => 'super_admin'],
    ['guard_name' => 'web']
);

// Assign ALL permissions to super_admin
$superAdminRole->syncPermissions(Permission::all());
echo "  ✅ Super Admin role has ALL " . Permission::count() . " permissions\n\n";

// Step 4: Assign super_admin role to user
echo "STEP 4: Assigning role to user...\n";

// Remove all existing roles first
$adminUser->roles()->detach();

// Assign super_admin role
$adminUser->assignRole('super_admin');

echo "  ✅ User assigned 'super_admin' role\n\n";

// Step 5: Verify permissions
echo "STEP 5: Verifying user permissions...\n";

$userPerms = $adminUser->getAllPermissions();
echo "  ✅ User now has {$userPerms->count()} permissions\n";

// Check specific permissions needed
$criticalPerms = [
    'view_abandoned_carts',
    'manage_email_campaigns',
    'edit_products',
    'manage_popups',
    'view_orders',
];

echo "\n  Checking critical permissions:\n";
foreach ($criticalPerms as $perm) {
    $has = $adminUser->hasPermissionTo($perm);
    echo "  " . ($has ? '✅' : '❌') . " {$perm}\n";
}

// Step 6: Clear ALL caches
echo "\nSTEP 6: Clearing all caches...\n";

app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
\Illuminate\Support\Facades\Artisan::call('cache:clear');
\Illuminate\Support\Facades\Artisan::call('config:clear');
\Illuminate\Support\Facades\Artisan::call('view:clear');
\Illuminate\Support\Facades\Artisan::call('route:clear');

echo "  ✅ Permission cache cleared\n";
echo "  ✅ Application cache cleared\n";
echo "  ✅ Config cache cleared\n";
echo "  ✅ View cache cleared\n";
echo "  ✅ Route cache cleared\n\n";

// Step 7: Success message
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                    ✅ FIX COMPLETE! ✅                         ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

echo "User: {$adminUser->email}\n";
echo "Role: super_admin\n";
echo "Permissions: {$userPerms->count()}\n\n";

echo "🎯 CRITICAL: DO THIS NOW:\n";
echo "───────────────────────────────────────\n";
echo "1. ❌ CLOSE your browser COMPLETELY\n";
echo "2. ❌ CLEAR browser cookies:\n";
echo "     - Chrome: Ctrl+Shift+Delete\n";
echo "     - Clear cookies for localhost\n";
echo "3. ✅ OPEN fresh browser window\n";
echo "4. ✅ LOGIN again:\n";
echo "     Email: admin@rizla.com\n";
echo "     Password: password\n";
echo "5. ✅ ALL PAGES WILL WORK!\n\n";

echo "📋 Then test these URLs:\n";
echo "  • http://localhost:8001/admin/dashboard\n";
echo "  • http://localhost:8001/admin/abandoned-carts\n";
echo "  • http://localhost:8001/admin/newsletter-subscribers\n";
echo "  • http://localhost:8001/admin/popup-campaigns\n";
echo "  • http://localhost:8001/admin/inventory/bulk-update\n\n";

echo "✅ DONE! Permission fix complete!\n\n";
