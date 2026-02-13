<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BusinessProfile;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class B2BReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
        $this->middleware('permission:view_b2b_reports');
    }

    /**
     * Display B2B analytics dashboard
     */
    public function analytics()
    {
        // Get date range (default to last 30 days)
        $startDate = request('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = request('end_date', now()->format('Y-m-d'));

        // Statistics Cards
        $stats = [
            'total_b2b_sales' => Order::b2b()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
            'total_b2b_orders' => Order::b2b()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_business_customers' => BusinessProfile::approved()->count(),
            'pending_approvals' => BusinessProfile::pending()->count(),
            'avg_order_value' => Order::b2b()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->avg('total_amount'),
            'total_b2c_sales' => Order::b2c()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
        ];

        // B2B vs B2C Sales Chart (Last 12 months)
        $salesComparison = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN is_b2b_order = 1 THEN total_amount ELSE 0 END) as b2b_sales'),
                DB::raw('SUM(CASE WHEN is_b2b_order = 0 THEN total_amount ELSE 0 END) as b2c_sales')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Top 10 Business Customers
        $topCustomers = User::whereHas('businessProfile', function ($query) {
            $query->approved();
        })
        ->withSum(['orders as total_orders_value' => function ($query) use ($startDate, $endDate) {
            $query->where('is_b2b_order', true)
                  ->whereBetween('created_at', [$startDate, $endDate]);
        }], 'total_amount')
        ->withCount(['orders as total_orders_count' => function ($query) use ($startDate, $endDate) {
            $query->where('is_b2b_order', true)
                  ->whereBetween('created_at', [$startDate, $endDate]);
        }])
        ->orderByDesc('total_orders_value')
        ->take(10)
        ->get();

        // Best Selling B2B Products
        $bestSellingProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->where('orders.is_b2b_order', true)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        // Monthly Revenue Trend (Last 12 months)
        $monthlyRevenue = Order::b2b()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('DATE_FORMAT(created_at, "%M %Y") as month_label'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as order_count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month', 'month_label')
            ->orderBy('month', 'asc')
            ->get();

        // Business Type Distribution
        $businessTypeDistribution = BusinessProfile::approved()
            ->select('business_type', DB::raw('COUNT(*) as count'))
            ->groupBy('business_type')
            ->get();

        // Recent B2B Orders
        $recentOrders = Order::b2b()
            ->with(['user.businessProfile'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.b2b-analytics', compact(
            'stats',
            'salesComparison',
            'topCustomers',
            'bestSellingProducts',
            'monthlyRevenue',
            'businessTypeDistribution',
            'recentOrders',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export B2B data to Excel
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel export using Laravel Excel package
        // This would export B2B orders, customers, and products data

        return back()->with('info', 'Excel export feature coming soon!');
    }

    /**
     * Customer lifetime value report
     */
    public function customerLifetimeValue()
    {
        $customers = User::whereHas('businessProfile', function ($query) {
            $query->approved();
        })
        ->withSum(['orders as lifetime_value' => function ($query) {
            $query->where('is_b2b_order', true);
        }], 'total_amount')
        ->withCount(['orders as total_orders' => function ($query) {
            $query->where('is_b2b_order', true);
        }])
        ->with('businessProfile')
        ->orderByDesc('lifetime_value')
        ->paginate(20);

        return view('admin.reports.b2b-customer-lifetime-value', compact('customers'));
    }
}
