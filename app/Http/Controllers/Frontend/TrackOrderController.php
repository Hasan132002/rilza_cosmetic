<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('frontend.track-order');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::with(['items.product.images', 'statusHistory'])
            ->where('order_number', $request->order_number)
            ->where('customer_email', $request->email)
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found. Please check your order number and email address.');
        }

        return view('frontend.track-order', compact('order'));
    }
}
