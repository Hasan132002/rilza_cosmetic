<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Our Story',
                'slug' => 'our-story',
                'content' => '<h2>Welcome to Rizla Cosmetics</h2>
                <p>Founded in 2020, Rizla Cosmetics has been on a mission to bring premium, authentic beauty products to cosmetics enthusiasts across Pakistan. Our journey began with a simple belief: everyone deserves access to high-quality, safe, and affordable beauty products.</p>

                <h3>What Sets Us Apart</h3>
                <ul>
                    <li><strong>100% Authentic Products:</strong> We source all our products directly from authorized distributors and manufacturers.</li>
                    <li><strong>Quality Assurance:</strong> Every product undergoes rigorous quality checks before reaching you.</li>
                    <li><strong>Expert Guidance:</strong> Our team of beauty experts is always ready to help you choose the perfect products.</li>
                    <li><strong>Customer First:</strong> Your satisfaction is our top priority, and we stand behind every product we sell.</li>
                </ul>

                <h3>Our Promise</h3>
                <p>We are committed to providing you with an exceptional shopping experience, from browsing our carefully curated collection to receiving your order at your doorstep. Join thousands of satisfied customers who trust Rizla Cosmetics for all their beauty needs.</p>',
                'meta_title' => 'Our Story - Learn About Rizla Cosmetics',
                'meta_description' => 'Discover the story behind Rizla Cosmetics, Pakistan\'s trusted source for authentic beauty products since 2020.',
                'is_active' => true,
            ],
            [
                'title' => 'Shipping Information',
                'slug' => 'shipping-information',
                'content' => '<h2>Shipping & Delivery</h2>
                <p>We strive to deliver your beauty essentials as quickly as possible. Here\'s everything you need to know about our shipping process:</p>

                <h3>Delivery Areas</h3>
                <p>We currently deliver to all major cities across Pakistan, including Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, and Quetta.</p>

                <h3>Delivery Timeframe</h3>
                <ul>
                    <li><strong>Major Cities:</strong> 2-3 business days</li>
                    <li><strong>Other Cities:</strong> 3-5 business days</li>
                    <li><strong>Remote Areas:</strong> 5-7 business days</li>
                </ul>

                <h3>Shipping Charges</h3>
                <p>Standard shipping charges apply to all orders. Free shipping is available on orders above PKR 2,500.</p>

                <h3>Order Tracking</h3>
                <p>Once your order is dispatched, you will receive a tracking number via SMS and email to monitor your delivery status.</p>

                <h3>Cash on Delivery</h3>
                <p>We offer Cash on Delivery (COD) service for all orders. Payment can be made in cash to our delivery partner upon receiving your order.</p>',
                'meta_title' => 'Shipping & Delivery Information - Rizla Cosmetics',
                'meta_description' => 'Learn about our shipping policies, delivery timeframes, and charges for orders across Pakistan.',
                'is_active' => true,
            ],
            [
                'title' => 'Return & Exchange Policy',
                'slug' => 'return-exchange-policy',
                'content' => '<h2>Return & Exchange Policy</h2>
                <p>Your satisfaction is our priority. If you\'re not completely satisfied with your purchase, we\'re here to help.</p>

                <h3>Return Eligibility</h3>
                <p>You may return products within 7 days of delivery if:</p>
                <ul>
                    <li>The product is unused and in its original packaging</li>
                    <li>All seals and tags are intact</li>
                    <li>You have the original invoice</li>
                    <li>The product is not on our non-returnable list</li>
                </ul>

                <h3>Non-Returnable Items</h3>
                <ul>
                    <li>Opened or used cosmetic products (for hygiene reasons)</li>
                    <li>Products without original packaging or tags</li>
                    <li>Sale or clearance items</li>
                    <li>Gift cards or vouchers</li>
                </ul>

                <h3>Exchange Process</h3>
                <p>To initiate a return or exchange:</p>
                <ol>
                    <li>Contact our customer service within 7 days of delivery</li>
                    <li>Provide your order number and reason for return</li>
                    <li>Pack the product securely in its original packaging</li>
                    <li>Our courier will collect the product from your address</li>
                </ol>

                <h3>Refunds</h3>
                <p>Once we receive and inspect your return, we will process your refund within 7-10 business days. The refund will be issued to your original payment method.</p>

                <h3>Damaged or Defective Products</h3>
                <p>If you receive a damaged or defective product, please contact us immediately. We will arrange a free replacement or full refund at no additional cost.</p>',
                'meta_title' => 'Return & Exchange Policy - Rizla Cosmetics',
                'meta_description' => 'Read our comprehensive return and exchange policy. We offer hassle-free returns within 7 days of delivery.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }
    }
}
