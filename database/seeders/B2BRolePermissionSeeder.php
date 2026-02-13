<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class B2BRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create B2B-specific permissions
        $permissions = [
            'view_wholesale_prices',
            'place_b2b_orders',
            'manage_b2b_customers',
            'approve_b2b_registrations',
            'set_wholesale_prices',
            'view_b2b_reports',
            'assign_sales_representatives',
            'download_b2b_invoices',
            'export_b2b_data',
            'manage_b2b_pricing_tiers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create business_customer role
        $businessCustomer = Role::firstOrCreate(['name' => 'business_customer']);
        $businessCustomer->syncPermissions([
            'view_wholesale_prices',
            'place_b2b_orders',
            'download_b2b_invoices',
        ]);

        // Create sales_representative role
        $salesRep = Role::firstOrCreate(['name' => 'sales_representative']);
        $salesRep->syncPermissions([
            'view_wholesale_prices',
            'manage_b2b_customers',
            'view_b2b_reports',
            'download_b2b_invoices',
        ]);

        // Get or create admin role and assign all B2B permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_wholesale_prices',
            'place_b2b_orders',
            'manage_b2b_customers',
            'approve_b2b_registrations',
            'set_wholesale_prices',
            'view_b2b_reports',
            'assign_sales_representatives',
            'download_b2b_invoices',
            'export_b2b_data',
            'manage_b2b_pricing_tiers',
        ]);

        $this->command->info('B2B roles and permissions created successfully!');
        $this->command->info('- business_customer role: view_wholesale_prices, place_b2b_orders, download_b2b_invoices');
        $this->command->info('- sales_representative role: view_wholesale_prices, manage_b2b_customers, view_b2b_reports, download_b2b_invoices');
        $this->command->info('- admin role: All B2B permissions granted');
    }
}
