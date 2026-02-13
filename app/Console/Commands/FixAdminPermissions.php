<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FixAdminPermissions extends Command
{
    protected $signature = 'admin:fix-permissions';
    protected $description = 'Fix admin permissions for all admin users';

    public function handle()
    {
        $this->info('🔧 Fixing Admin Permissions...');
        $this->newLine();

        // Get all admin users
        $adminUsers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['super_admin', 'admin']);
        })->get();

        if ($adminUsers->isEmpty()) {
            $this->error('❌ No admin users found!');
            return 1;
        }

        $this->info("Found {$adminUsers->count()} admin users:");
        foreach ($adminUsers as $user) {
            $this->line("  • {$user->email} - " . $user->roles->pluck('name')->join(', '));
        }
        $this->newLine();

        // Ensure all permissions exist
        $this->info('Creating missing permissions...');

        $allPerms = [
            'view_dashboard', 'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_orders', 'edit_orders', 'delete_orders', 'print_invoice',
            'manage_banners', 'manage_pages', 'manage_blogs', 'manage_announcements',
            'manage_coupons', 'manage_flash_sales', 'manage_email_campaigns',
            'manage_popups', 'view_abandoned_carts',
            'view_reports', 'export_reports',
            'manage_settings', 'manage_seo', 'manage_social_media',
            'manage_roles', 'manage_permissions', 'manage_users',
        ];

        foreach ($allPerms as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $this->info("✅ All " . count($allPerms) . " permissions ensured");
        $this->newLine();

        // Sync permissions to super_admin role
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
            $this->info('✅ Super Admin role: ALL permissions');
        }

        // Sync permissions to admin role (exclude RBAC)
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $adminPerms = Permission::whereNotIn('name', ['manage_roles', 'manage_permissions', 'manage_users'])->get();
            $admin->syncPermissions($adminPerms);
            $this->info('✅ Admin role: ' . $adminPerms->count() . ' permissions');
        }

        $this->newLine();

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->call('cache:clear');

        $this->newLine();
        $this->info('╔═══════════════════════════════════════════════╗');
        $this->info('║          ✅ PERMISSIONS FIXED! ✅             ║');
        $this->info('╚═══════════════════════════════════════════════╝');
        $this->newLine();

        $this->warn('🚨 IMPORTANT: YOU MUST DO THIS NOW:');
        $this->line('1. Close your browser COMPLETELY');
        $this->line('2. Clear browser cookies (Ctrl+Shift+Delete)');
        $this->line('3. Open fresh browser');
        $this->line('4. Login: admin@rizla.com / password');
        $this->line('5. All pages will work!');
        $this->newLine();

        return 0;
    }
}
