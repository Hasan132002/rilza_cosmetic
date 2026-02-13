<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryLogController extends Controller
{
    /**
     * Display inventory logs
     */
    public function index(Request $request)
    {
        $query = InventoryLog::with(['product', 'user']);

        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(30);

        $products = Product::active()->orderBy('name')->get();

        $stats = [
            'total_logs' => InventoryLog::count(),
            'today_logs' => InventoryLog::whereDate('created_at', today())->count(),
            'added_today' => InventoryLog::whereDate('created_at', today())
                                        ->where('action', 'added')
                                        ->sum('quantity_changed'),
            'sold_today' => abs(InventoryLog::whereDate('created_at', today())
                                           ->where('action', 'sold')
                                           ->sum('quantity_changed')),
        ];

        return view('admin.inventory-logs.index', compact('logs', 'products', 'stats'));
    }

    /**
     * Show logs for a specific product
     */
    public function show(Product $product)
    {
        $logs = InventoryLog::with('user')
                           ->where('product_id', $product->id)
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);

        return view('admin.inventory-logs.show', compact('product', 'logs'));
    }
}
