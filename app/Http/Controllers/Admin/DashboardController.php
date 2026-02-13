<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

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
}
