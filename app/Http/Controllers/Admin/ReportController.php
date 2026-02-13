<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Sales Report
     */
    public function salesReport(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, monthly, yearly
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        if ($period === 'daily') {
            // Daily sales for the month
            $sales = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('order_status', '!=', 'cancelled')
                ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $labels = $sales->pluck('date')->map(fn($d) => date('d M', strtotime($d)))->toArray();
            $data = $sales->pluck('total')->toArray();
        } elseif ($period === 'monthly') {
            // Monthly sales for the year
            $sales = Order::whereYear('created_at', $year)
                ->where('order_status', '!=', 'cancelled')
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as orders, SUM(total_amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $labels = $sales->pluck('month')->map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)))->toArray();
            $data = $sales->pluck('total')->toArray();
        } else {
            // Yearly sales
            $sales = Order::where('order_status', '!=', 'cancelled')
                ->selectRaw('YEAR(created_at) as year, COUNT(*) as orders, SUM(total_amount) as total')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $labels = $sales->pluck('year')->toArray();
            $data = $sales->pluck('total')->toArray();
        }

        // Summary stats
        $totalSales = Order::where('order_status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::where('order_status', '!=', 'cancelled')->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        return view('admin.reports.sales', compact('sales', 'labels', 'data', 'period', 'year', 'month', 'totalSales', 'totalOrders', 'averageOrderValue'));
    }

    /**
     * Order Report
     */
    public function orderReport(Request $request)
    {
        $query = Order::with('user', 'items');

        // Filters
        if ($request->has('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        // Summary by status
        $statusCounts = Order::selectRaw('order_status, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('order_status')
            ->get()
            ->keyBy('order_status');

        return view('admin.reports.orders', compact('orders', 'statusCounts'));
    }

    /**
     * Product Report
     */
    public function productReport(Request $request)
    {
        // Best selling products
        $bestSelling = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.order_status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();

        // Low stock products
        $lowStock = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity')
            ->get();

        // Out of stock products
        $outOfStock = Product::where('stock_quantity', 0)->get();

        // Most viewed products
        $mostViewed = Product::orderBy('view_count', 'desc')->limit(20)->get();

        return view('admin.reports.products', compact('bestSelling', 'lowStock', 'outOfStock', 'mostViewed'));
    }

    /**
     * Customer Report
     */
    public function customerReport(Request $request)
    {
        // Top customers by order value
        $topCustomers = User::role('customer')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->having('orders_count', '>', 0)
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(20)
            ->get();

        // Customer statistics
        $totalCustomers = User::role('customer')->count();
        $customersWithOrders = User::role('customer')->has('orders')->count();
        $newCustomersThisMonth = User::role('customer')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        return view('admin.reports.customers', compact('topCustomers', 'totalCustomers', 'customersWithOrders', 'newCustomersThisMonth'));
    }

    /**
     * Export to Excel
     */
    public function exportOrders(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->has('status') && $request->status != '') {
            $query->where('order_status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return Excel::download(new \App\Exports\OrdersExport($orders), 'orders-' . date('Y-m-d') . '.xlsx');
    }
}
