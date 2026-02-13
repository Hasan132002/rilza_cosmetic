<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BusinessProfile;
use App\Models\Product;
use App\Models\ProductB2BPricing;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class B2BTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating B2B test business profiles...');

        // Create 5 test business users with profiles
        $businesses = [
            [
                'name' => 'Sarah Ahmed',
                'email' => 'sarah@beautypalace.com',
                'company_name' => 'Beauty Palace Karachi',
                'business_type' => 'retailer',
                'status' => 'approved',
            ],
            [
                'name' => 'Ahmed Khan',
                'email' => 'ahmed@cosmeticswholesale.pk',
                'company_name' => 'Cosmetics Wholesale Hub',
                'business_type' => 'wholesaler',
                'status' => 'approved',
            ],
            [
                'name' => 'Fatima Ali',
                'email' => 'fatima@glamdistributors.com',
                'company_name' => 'Glam Distributors',
                'business_type' => 'distributor',
                'status' => 'pending',
            ],
            [
                'name' => 'Usman Malik',
                'email' => 'usman@beautyempire.pk',
                'company_name' => 'Beauty Empire Store',
                'business_type' => 'small_business',
                'status' => 'pending',
            ],
            [
                'name' => 'Zainab Hassan',
                'email' => 'zainab@rejecteddemo.com',
                'company_name' => 'Test Rejected Business',
                'business_type' => 'retailer',
                'status' => 'rejected',
            ],
        ];

        $createdUsers = [];

        foreach ($businesses as $business) {
            // Create user
            $user = User::create([
                'name' => $business['name'],
                'email' => $business['email'],
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'customer_type' => 'b2b',
                'is_b2b_approved' => $business['status'] === 'approved',
                'is_active' => true,
            ]);

            // Assign business_customer role
            $user->assignRole('business_customer');

            // Create business profile
            $profile = BusinessProfile::create([
                'user_id' => $user->id,
                'company_name' => $business['company_name'],
                'business_registration_number' => 'BRN-' . strtoupper(Str::random(8)),
                'tax_id_number' => 'TAX-' . rand(100000, 999999),
                'company_address' => rand(100, 999) . ' Business District, Karachi',
                'company_city' => 'Karachi',
                'company_phone' => '+92300' . rand(1000000, 9999999),
                'company_email' => $business['email'],
                'business_type' => $business['business_type'],
                'status' => $business['status'],
                'approved_by' => $business['status'] === 'approved' ? 1 : null,
                'approved_at' => $business['status'] === 'approved' ? now() : null,
                'rejection_reason' => $business['status'] === 'rejected' ? 'Incomplete documentation provided' : null,
                'admin_notes' => $business['status'] === 'approved' ? 'Verified and approved for wholesale pricing' : null,
            ]);

            if ($business['status'] === 'approved') {
                $createdUsers[] = $user;
            }

            $this->command->info("Created {$business['status']} business: {$business['company_name']}");
        }

        // Add wholesale pricing to 20 random products
        $this->command->info('Adding B2B wholesale pricing to products...');

        $products = Product::active()->inRandomOrder()->take(20)->get();

        foreach ($products as $product) {
            // Calculate wholesale pricing (20-40% off retail)
            $discountPercent = rand(20, 40);
            $wholesalePrice = $product->final_price * (1 - $discountPercent / 100);

            // Create bulk pricing tiers
            ProductB2BPricing::create([
                'product_id' => $product->id,
                'wholesale_price' => round($wholesalePrice, 2),
                'minimum_order_quantity' => rand(5, 15),
                'bulk_tier_1_qty' => 50,
                'bulk_tier_1_price' => round($wholesalePrice * 0.95, 2), // 5% off
                'bulk_tier_2_qty' => 100,
                'bulk_tier_2_price' => round($wholesalePrice * 0.90, 2), // 10% off
                'bulk_tier_3_qty' => 200,
                'bulk_tier_3_price' => round($wholesalePrice * 0.85, 2), // 15% off
                'is_available_for_b2b' => true,
            ]);

            $this->command->info("Added B2B pricing to: {$product->name}");
        }

        // Create 10 sample B2B orders
        $this->command->info('Creating sample B2B orders...');

        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered', 'delivered'];
        $productsWithB2B = Product::whereHas('b2bPricing', function ($query) {
            $query->where('is_available_for_b2b', true);
        })->get();

        for ($i = 0; $i < 10; $i++) {
            $user = $createdUsers[array_rand($createdUsers)];
            $status = $orderStatuses[array_rand($orderStatuses)];

            // Select 2-5 random products
            $orderProducts = $productsWithB2B->random(rand(2, 5));

            $subtotal = 0;
            $orderItems = [];

            foreach ($orderProducts as $product) {
                $quantity = rand(10, 50); // B2B quantities
                $price = $product->getWholesalePriceForQuantity($quantity);
                $itemSubtotal = $price * $quantity;
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Create order
            $order = Order::create([
                'order_number' => 'RIZ-B2B-' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->businessProfile->company_phone,
                'shipping_address' => $user->businessProfile->company_address,
                'shipping_city' => $user->businessProfile->company_city,
                'shipping_postal_code' => rand(70000, 79999),
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $subtotal,
                'payment_method' => 'cod',
                'order_status' => $status,
                'is_b2b_order' => true,
                'purchase_order_number' => 'PO-' . date('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => now()->subDays(rand(1, 90)), // Random dates in last 3 months
                'delivered_at' => $status === 'delivered' ? now()->subDays(rand(1, 30)) : null,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'product_sku' => $item['product']->sku,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Create status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $status,
                'notes' => 'B2B order ' . $status,
                'updated_by' => 1,
                'created_at' => $order->created_at,
            ]);

            $this->command->info("Created B2B order: {$order->order_number} - {$status} - Rs " . number_format($subtotal, 0));
        }

        $this->command->info('B2B test data seeding completed!');
        $this->command->info('===========================================');
        $this->command->info('Test Business Accounts Created:');
        $this->command->info('1. sarah@beautypalace.com (Approved Retailer)');
        $this->command->info('2. ahmed@cosmeticswholesale.pk (Approved Wholesaler)');
        $this->command->info('3. fatima@glamdistributors.com (Pending Distributor)');
        $this->command->info('4. usman@beautyempire.pk (Pending Small Business)');
        $this->command->info('5. zainab@rejecteddemo.com (Rejected)');
        $this->command->info('Password for all: password123');
        $this->command->info('===========================================');
    }
}
