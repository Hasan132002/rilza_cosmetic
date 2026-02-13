<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display all orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        // Filter by status
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'statusHistory.user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,packed,shipped,out_for_delivery,delivered,cancelled',
            'tracking_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $this->orderService->updateStatus(
            $order,
            $request->status,
            $request->notes,
            $request->tracking_number
        );

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Print invoice for the order
     */
    public function invoice(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.invoice', compact('order'));
    }
}
