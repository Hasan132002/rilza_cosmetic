<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Models\Coupon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with real statistics.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock_products' => Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                                          ->where('stock_quantity', '>', 0)
                                          ->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),

            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'shipped_orders' => Order::where('order_status', 'shipped')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),

            'total_revenue' => Order::sum('total_amount'),
            'todays_revenue' => Order::whereDate('created_at', today())->sum('total_amount'),

            'total_customers' => User::role('customer')->count(),
            'total_categories' => Category::count(),
        ];

        $recent_orders = Order::with(['user', 'items'])->latest()->take(5)->get();
        $low_stock_products = Product::with('category')
                                     ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                                     ->where('stock_quantity', '>', 0)
                                     ->orderBy('stock_quantity', 'asc')
                                     ->take(10)
                                     ->get();
        $bestsellers = Product::with(['images', 'category'])->where('is_bestseller', true)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products', 'bestsellers'));
    }

    /**
     * Display the Super Admin dashboard with full system overview.
     */
    public function superAdmin()
    {
        // Store Stats (same as admin)
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock_products' => Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                                          ->where('stock_quantity', '>', 0)
                                          ->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),

            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'shipped_orders' => Order::where('order_status', 'shipped')->count(),
            'delivered_orders' => Order::where('order_status', 'delivered')->count(),

            'total_revenue' => Order::sum('total_amount'),
            'todays_revenue' => Order::whereDate('created_at', today())->sum('total_amount'),
            'this_month_revenue' => Order::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->sum('total_amount'),

            'total_customers' => User::role('customer')->count(),
            'total_categories' => Category::count(),
        ];

        // System Stats (Super Admin exclusive)
        $system_stats = [
            'total_users' => User::count(),
            'total_admins' => User::role('admin')->count(),
            'total_super_admins' => User::role('super_admin')->count(),
            'total_staff' => User::role('staff')->count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::where('is_active', true)
                                      ->where(function ($q) {
                                          $q->whereNull('valid_until')
                                            ->orWhere('valid_until', '>=', now());
                                      })
                                      ->count(),
        ];

        // Recent Activity Logs
        $recent_activities = ActivityLog::with('user')
                                       ->latest()
                                       ->take(10)
                                       ->get();

        // All Admin Users
        $admin_users = User::role(['super_admin', 'admin', 'staff'])
                          ->with('roles')
                          ->latest()
                          ->get();

        // Recent Orders
        $recent_orders = Order::with(['user', 'items'])->latest()->take(5)->get();

        // Low Stock
        $low_stock_products = Product::with('category')
                                     ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                                     ->where('stock_quantity', '>', 0)
                                     ->orderBy('stock_quantity', 'asc')
                                     ->take(10)
                                     ->get();

        // Bestsellers
        $bestsellers = Product::with(['images', 'category'])->where('is_bestseller', true)->take(5)->get();

        // Monthly Revenue (last 6 months)
        $monthly_revenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as order_count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Order Status Distribution
        $order_status_distribution = Order::select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->get()
            ->pluck('count', 'order_status');

        return view('admin.super-admin-dashboard', compact(
            'stats',
            'system_stats',
            'recent_activities',
            'admin_users',
            'recent_orders',
            'low_stock_products',
            'bestsellers',
            'monthly_revenue',
            'order_status_distribution'
        ));
    }
}
