<?php
/**
 * Quick Permission Fix Script
 * Run this to add missing permissions without re-seeding
 *
 * Usage: php FIX_PERMISSIONS.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "🔧 Adding Missing Permissions...\n\n";

// Define missing permissions
$missingPermissions = [
    'manage_popups',
    'view_abandoned_carts',
];

$created = 0;
$existing = 0;

foreach ($missingPermissions as $permName) {
    $perm = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);

    if ($perm->wasRecentlyCreated) {
        echo "✅ Created: {$permName}\n";
        $created++;
    } else {
        echo "ℹ️  Already exists: {$permName}\n";
        $existing++;
    }
}

echo "\n📋 Assigning Permissions to Roles...\n\n";

// Assign to admin role
$admin = Role::where('name', 'admin')->first();
if ($admin) {
    $admin->givePermissionTo($missingPermissions);
    echo "✅ Assigned to 'admin' role\n";
} else {
    echo "❌ Admin role not found!\n";
}

// Assign to super_admin role
$superAdmin = Role::where('name', 'super_admin')->first();
if ($superAdmin) {
    $superAdmin->givePermissionTo($missingPermissions);
    echo "✅ Assigned to 'super_admin' role\n";
} else {
    echo "❌ Super admin role not found!\n";
}

echo "\n🎉 COMPLETE!\n";
echo "Created: {$created} permissions\n";
echo "Already existed: {$existing} permissions\n";
echo "\n✅ All permissions are now ready!\n";
echo "💡 Logout from admin and login again to apply changes.\n";
