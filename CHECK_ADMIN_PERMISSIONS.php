<?php
/**
 * Check Admin User Permissions
 * Run: php CHECK_ADMIN_PERMISSIONS.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "\n╔════════════════════════════════════════════════════════╗\n";
echo "║     ADMIN USER PERMISSION DIAGNOSTIC TOOL             ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// Find admin user
$adminUser = User::where('email', 'admin@rizlacosmetics.com')->first();

if (!$adminUser) {
    echo "❌ ERROR: User 'admin@rizlacosmetics.com' not found!\n";
    echo "   Create this user first.\n\n";
    exit(1);
}

echo "✅ User Found: {$adminUser->name} ({$adminUser->email})\n";
echo "   ID: {$adminUser->id}\n\n";

// Check roles
echo "═══ USER ROLES ═══\n";
$roles = $adminUser->roles;

if ($roles->isEmpty()) {
    echo "❌ NO ROLES ASSIGNED!\n";
    echo "   This user has no roles. Assigning 'admin' role...\n\n";

    $adminRole = Role::where('name', 'admin')->first();
    if ($adminRole) {
        $adminUser->assignRole('admin');
        echo "✅ 'admin' role assigned!\n\n";
    } else {
        echo "❌ 'admin' role doesn't exist! Run: php artisan db:seed --class=RolePermissionSeeder\n\n";
        exit(1);
    }
} else {
    foreach ($roles as $role) {
        echo "✅ Role: {$role->name}\n";
    }
    echo "\n";
}

// Check permissions
echo "═══ USER PERMISSIONS ═══\n";
$permissions = $adminUser->getAllPermissions();

if ($permissions->isEmpty()) {
    echo "❌ NO PERMISSIONS!\n";
    echo "   User has roles but no permissions assigned to those roles.\n";
    echo "   Running permission fix...\n\n";
} else {
    echo "Total Permissions: {$permissions->count()}\n\n";

    // Check specific permissions needed for problematic pages
    $requiredPerms = [
        'manage_email_campaigns' => '/admin/newsletter-subscribers',
        'view_abandoned_carts' => '/admin/abandoned-carts',
        'edit_products' => '/admin/inventory/bulk-update',
        'manage_popups' => '/admin/popup-campaigns',
    ];

    echo "Checking Required Permissions:\n";
    echo "─────────────────────────────────────────────────\n";

    foreach ($requiredPerms as $perm => $route) {
        $has = $adminUser->hasPermissionTo($perm);
        $status = $has ? '✅' : '❌';
        echo "{$status} {$perm}\n";
        echo "   Route: {$route}\n";
    }
    echo "\n";
}

// List all permissions
echo "═══ ALL USER PERMISSIONS ═══\n";
foreach ($permissions->sortBy('name') as $perm) {
    echo "  • {$perm->name}\n";
}

echo "\n";

// Check admin role permissions
echo "═══ ADMIN ROLE PERMISSIONS ═══\n";
$adminRole = Role::where('name', 'admin')->first();

if ($adminRole) {
    $rolePerms = $adminRole->permissions;
    echo "Total: {$rolePerms->count()} permissions\n\n";

    foreach ($rolePerms->sortBy('name') as $perm) {
        echo "  • {$perm->name}\n";
    }
} else {
    echo "❌ Admin role not found!\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                   DIAGNOSTIC COMPLETE                  ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// Auto-fix missing permissions
echo "🔧 AUTO-FIX: Ensuring all required permissions exist and are assigned...\n\n";

$requiredPermissions = [
    'manage_popups',
    'view_abandoned_carts',
    'manage_email_campaigns',
];

foreach ($requiredPermissions as $permName) {
    $perm = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);

    if ($adminRole) {
        $adminRole->givePermissionTo($permName);
    }
}

// Clear permission cache
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

echo "✅ All required permissions created and assigned!\n";
echo "✅ Permission cache cleared!\n\n";

echo "🎯 NEXT STEPS:\n";
echo "1. Logout from admin panel\n";
echo "2. Close all browser tabs\n";
echo "3. Login again: admin@rizlacosmetics.com / password\n";
echo "4. All pages should work now!\n\n";
