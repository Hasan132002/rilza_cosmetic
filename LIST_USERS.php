<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "\n📋 ALL USERS IN DATABASE:\n\n";

$users = User::with('roles')->get();

if ($users->isEmpty()) {
    echo "❌ No users found in database!\n";
    echo "   Run: php artisan db:seed\n\n";
    exit(1);
}

foreach ($users as $user) {
    echo "───────────────────────────────────────\n";
    echo "👤 Name: {$user->name}\n";
    echo "📧 Email: {$user->email}\n";
    echo "🔑 ID: {$user->id}\n";
    echo "👑 Roles: ";

    if ($user->roles->isEmpty()) {
        echo "NO ROLES\n";
    } else {
        echo $user->roles->pluck('name')->join(', ') . "\n";
    }

    echo "\n";
}

echo "───────────────────────────────────────\n";
echo "\nTotal Users: {$users->count()}\n\n";

// Show admin/super_admin users specifically
$admins = User::role(['admin', 'super_admin'])->get();
if ($admins->count() > 0) {
    echo "🔑 ADMIN USERS:\n";
    foreach ($admins as $admin) {
        echo "   • {$admin->email} - " . $admin->roles->pluck('name')->join(', ') . "\n";
    }
    echo "\n";
}
