<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Middleware applied in routes/web.php

    public function dashboard()
    {
        $stats = [
            'total_orders' => auth()->user()->orders()->count(),
            'pending_orders' => auth()->user()->orders()->where('order_status', 'pending')->count(),
            'total_spent' => auth()->user()->orders()->sum('total_amount'),
        ];

        $recent_orders = auth()->user()->orders()->latest()->take(5)->get();

        return view('frontend.account.dashboard', compact('stats', 'recent_orders'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('frontend.account.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = auth()->user()->orders()->with(['items.product', 'statusHistory'])->findOrFail($id);
        return view('frontend.account.order-details', compact('order'));
    }
}
