<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $invoiceService;
    protected $cartService;

    public function __construct(InvoiceService $invoiceService, CartService $cartService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
        $this->cartService = $cartService;
    }

    /**
     * Display user's order history
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load(['items.product', 'statusHistory']);

        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Download invoice for an order
     */
    public function downloadInvoice(Order $order)
    {
        // Ensure user can only download their own invoices
        if ($order->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to invoice');
        }

        // Check if user has permission for B2B orders
        if ($order->is_b2b_order && !Auth::user()->can('download_b2b_invoices')) {
            abort(403, 'You do not have permission to download B2B invoices');
        }

        return $this->invoiceService->downloadInvoice($order);
    }

    /**
     * Reorder - add all items from previous order to cart
     */
    public function reorder(Order $order)
    {
        // Ensure user can only reorder their own orders
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to order'
            ], 403);
        }

        $order->load('items.product');

        $addedItems = 0;
        $failedItems = [];
        $cart = $this->cartService->getCart();

        foreach ($order->items as $item) {
            $product = $item->product;

            // Check if product still exists and is available
            if (!$product || !$product->is_active) {
                $failedItems[] = $item->product_name . ' (No longer available)';
                continue;
            }

            // Check stock
            if ($product->stock_quantity < $item->quantity) {
                if ($product->stock_quantity > 0) {
                    // Add available quantity
                    $result = $this->cartService->addToCart($product->id, $product->stock_quantity);
                    if ($result['success']) {
                        $addedItems++;
                    }
                    $failedItems[] = $item->product_name . ' (Only ' . $product->stock_quantity . ' available)';
                } else {
                    $failedItems[] = $item->product_name . ' (Out of stock)';
                }
                continue;
            }

            // Check MOQ for B2B customers
            if (Auth::user()->isB2BApproved() && $product->isAvailableForB2B()) {
                $moq = $product->getB2BMinimumQuantity();
                if ($item->quantity < $moq) {
                    // Adjust to MOQ
                    $result = $this->cartService->addToCart($product->id, $moq);
                    if ($result['success']) {
                        $addedItems++;
                    } else {
                        $failedItems[] = $item->product_name . ' - ' . $result['message'];
                    }
                    continue;
                }
            }

            // Add to cart
            $result = $this->cartService->addToCart($product->id, $item->quantity);
            if ($result['success']) {
                $addedItems++;
            } else {
                $failedItems[] = $item->product_name . ' - ' . $result['message'];
            }
        }

        // Prepare response message
        $message = '';
        if ($addedItems > 0) {
            $message = "{$addedItems} items added to cart successfully!";
        }

        if (count($failedItems) > 0) {
            if ($addedItems > 0) {
                $message .= ' However, some items could not be added: ';
            } else {
                $message = 'Failed to add items: ';
            }
            $message .= implode(', ', $failedItems);
        }

        return response()->json([
            'success' => $addedItems > 0,
            'message' => $message,
            'added_count' => $addedItems,
            'failed_count' => count($failedItems),
            'failed_items' => $failedItems,
            'cart_count' => $this->cartService->getCartCount()
        ]);
    }

    /**
     * Cancel order (only if pending)
     */
    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized access to order');
        }

        // Only pending orders can be cancelled
        if ($order->order_status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled');
        }

        // Update order status
        $order->update(['order_status' => 'cancelled']);

        // Restore stock
        foreach ($order->items as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        return back()->with('success', 'Order cancelled successfully');
    }
}
