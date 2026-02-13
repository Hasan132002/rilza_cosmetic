<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "\n╔═══════════════════════════════════════════╗\n";
echo "║   DATABASE ROLE FIX - DIRECT INSERTION   ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

// Step 1: Check current state
echo "STEP 1: Checking current role assignments...\n";
$existing = DB::table('model_has_roles')
    ->where('model_id', 1)
    ->where('model_type', 'App\\Models\\User')
    ->get();

echo "Current roles for user ID 1: " . $existing->count() . "\n";

if ($existing->count() > 0) {
    foreach ($existing as $e) {
        $role = DB::table('roles')->where('id', $e->role_id)->first();
        echo "  • " . $role->name . "\n";
    }
}

// Step 2: Get super_admin role ID
echo "\nSTEP 2: Finding super_admin role...\n";
$superAdminRole = DB::table('roles')->where('name', 'super_admin')->first();

if (!$superAdminRole) {
    echo "❌ ERROR: super_admin role not found in database!\n";
    echo "   Run: php artisan db:seed --class=RolePermissionSeeder\n";
    exit(1);
}

echo "✅ Found super_admin role (ID: {$superAdminRole->id})\n";

// Step 3: Delete existing role assignments for user 1
echo "\nSTEP 3: Removing old role assignments...\n";
$deleted = DB::table('model_has_roles')
    ->where('model_id', 1)
    ->where('model_type', 'App\\Models\\User')
    ->delete();

echo "✅ Removed {$deleted} old assignments\n";

// Step 4: Insert fresh super_admin role
echo "\nSTEP 4: Inserting super_admin role...\n";

DB::table('model_has_roles')->insert([
    'role_id' => $superAdminRole->id,
    'model_type' => 'App\\Models\\User',
    'model_id' => 1
]);

echo "✅ INSERTED super_admin role for user ID 1\n";

// Step 5: Verify
echo "\nSTEP 5: Verifying...\n";
$check = DB::table('model_has_roles')
    ->where('model_id', 1)
    ->where('model_type', 'App\\Models\\User')
    ->count();

echo "✅ User now has {$check} role(s) in database\n";

// Step 6: Clear caches
echo "\nSTEP 6: Clearing all caches...\n";
Artisan::call('permission:cache-reset');
Artisan::call('cache:clear');
echo "✅ Permission cache cleared\n";
echo "✅ Application cache cleared\n";

echo "\n╔═══════════════════════════════════════════╗\n";
echo "║          ✅ DATABASE FIX DONE! ✅         ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

echo "🎯 NOW DO THIS:\n";
echo "1. Go to login page\n";
echo "2. Login with:\n";
echo "   Email: admin@rizla.com\n";
echo "   Password: password\n";
echo "3. ✅ IT WILL WORK!\n\n";

echo "If still error, close browser and clear cookies!\n\n";
