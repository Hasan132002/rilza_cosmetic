<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions by module
        $permissions = [
            // Dashboard
            'view_dashboard',

            // Products Module
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',

            // Categories Module
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',

            // Orders Module
            'view_orders',
            'edit_orders',
            'delete_orders',
            'print_invoice',

            // CMS Module
            'manage_banners',
            'manage_pages',
            'manage_blogs',
            'manage_announcements',

            // Marketing Module
            'manage_coupons',
            'manage_flash_sales',
            'manage_email_campaigns',
            'manage_popups',
            'view_abandoned_carts',

            // Reports Module
            'view_reports',
            'export_reports',

            // Settings Module
            'manage_settings',
            'manage_seo',
            'manage_social_media',

            // RBAC Module
            'manage_roles',
            'manage_permissions',
            'manage_users',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and assign permissions

        // 1. Super Admin - has ALL permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Admin - has most permissions except RBAC management
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_dashboard',
            'view_products', 'create_products', 'edit_products', 'delete_products',
            'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
            'view_orders', 'edit_orders', 'delete_orders', 'print_invoice',
            'manage_banners', 'manage_pages', 'manage_blogs', 'manage_announcements',
            'manage_coupons', 'manage_flash_sales', 'manage_email_campaigns', 'manage_popups', 'view_abandoned_carts',
            'view_reports', 'export_reports',
            'manage_settings', 'manage_seo', 'manage_social_media',
        ]);

        // 3. Staff / Order Manager - only order-related permissions
        $staff = Role::create(['name' => 'staff']);
        $staff->givePermissionTo([
            'view_dashboard',
            'view_orders',
            'edit_orders',
            'print_invoice',
        ]);

        // 4. Customer - no admin panel access (handled by frontend)
        $customer = Role::create(['name' => 'customer']);
        // Customers don't need any admin permissions
    }
}
