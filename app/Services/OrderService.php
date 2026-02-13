<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Cart;
use App\Models\Coupon;
use App\Mail\OrderPlaced;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * Create order from cart
     */
    public function createOrderFromCart(array $customerData, Cart $cart, bool $isB2BOrder = false)
    {
        return DB::transaction(function () use ($customerData, $cart, $isB2BOrder) {
            // Handle coupon if applied
            $discountAmount = $cart->discount_amount ?? 0;
            $couponCode = $cart->coupon_code;

            // Prepare shipping address
            $shippingAddress = $customerData['address_line_1'];
            if (!empty($customerData['address_line_2'])) {
                $shippingAddress .= ', ' . $customerData['address_line_2'];
            }
            if (!empty($customerData['state'])) {
                $shippingAddress .= ', ' . $customerData['state'];
            }

            // Calculate subtotal and total with B2B wholesale pricing if applicable
            $subtotal = 0;
            $orderItems = [];

            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;
                $price = $product->final_price;

                // Use wholesale pricing for B2B orders
                if ($isB2BOrder && $product->isAvailableForB2B()) {
                    $price = $product->getWholesalePriceForQuantity($cartItem->quantity);
                }

                $itemSubtotal = $price * $cartItem->quantity;
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product' => $product,
                    'variant_id' => $cartItem->product_variant_id,
                    'variant' => $cartItem->variant,
                    'price' => $price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Recalculate total with discounts
            $totalAmount = $subtotal - $discountAmount;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $customerData['name'],
                'customer_email' => $customerData['email'],
                'customer_phone' => $customerData['phone'],
                'shipping_address' => $shippingAddress,
                'shipping_city' => $customerData['city'],
                'shipping_postal_code' => $customerData['postal_code'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
                'total_amount' => $totalAmount,
                'payment_method' => 'cod',
                'order_status' => 'pending',
                'is_b2b_order' => $isB2BOrder,
                'purchase_order_number' => $customerData['purchase_order_number'] ?? null,
            ]);

            // Increment coupon usage count if coupon was applied
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // Create order items with proper pricing
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_variant_id' => $item['variant_id'],
                    'product_name' => $item['product']->name,
                    'product_sku' => $item['product']->sku,
                    'variant_name' => $item['variant']?->variant_name,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Reduce product stock
                $item['product']->decrement('stock_quantity', $item['quantity']);
            }

            // Record status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'notes' => 'Order placed',
                'updated_by' => Auth::id(),
            ]);

            // Clear cart and reset coupon
            $cart->items()->delete();
            $cart->update([
                'coupon_code' => null,
                'discount_amount' => 0
            ]);

            // Send order confirmation email
            Mail::to($order->customer_email)->send(new OrderPlaced($order));

            return $order;
        });
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order, string $status, ?string $notes = null, ?string $trackingNumber = null)
    {
        $oldStatus = $order->order_status;

        $order->update([
            'order_status' => $status,
            'tracking_number' => $trackingNumber ?? $order->tracking_number,
            'delivered_at' => $status === 'delivered' ? now() : $order->delivered_at,
        ]);

        // Record history
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $status,
            'notes' => $notes,
            'updated_by' => Auth::id(),
        ]);

        // Send status update email
        Mail::to($order->customer_email)->send(new OrderStatusUpdated($order, $oldStatus));

        return $order;
    }
}
