<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $couponService;

    public function __construct(CartService $cartService, OrderService $orderService, CouponService $couponService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->couponService = $couponService;
    }

    /**
     * Display checkout page
     */
    public function index()
    {
        // Check admin setting for login requirement
        $requireLogin = \App\Models\Setting::where('key', 'require_login_for_checkout')->value('value') ?? '1';

        // If login required and user not logged in, redirect to login
        if ($requireLogin == '1' && !auth()->check()) {
            session()->put('url.intended', route('checkout'));
            return redirect()->route('login')
                ->with('info', 'Please login to proceed with checkout');
        }

        $cart = $this->cartService->getCart();
        $cart->load(['items.product.images']);

        if ($cart->items->count() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty!');
        }

        // Get user's default address or last used address (if logged in)
        $defaultAddress = null;
        if (auth()->check()) {
            $defaultAddress = auth()->user()->addresses()->where('is_default', true)->first()
                           ?? auth()->user()->addresses()->latest()->first();
        }

        return view('frontend.checkout', compact('cart', 'defaultAddress'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|min:10|max:20',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:10',
            'purchase_order_number' => 'nullable|string|max:100',
        ]);

        $cart = $this->cartService->getCart();

        if ($cart->items->count() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty!');
        }

        // Check if user is B2B and mark order accordingly
        $isB2BOrder = auth()->check() && auth()->user()->isB2BApproved();

        // Create order
        $order = $this->orderService->createOrderFromCart($validated, $cart, $isB2BOrder);

        // TODO: Send order confirmation email in Phase 6

        return redirect()->route('order.confirmation', $order)->with('success', 'Order placed successfully!');
    }

    /**
     * Display order confirmation
     */
    public function confirmation($orderId)
    {
        $order = \App\Models\Order::with(['items.product'])->findOrFail($orderId);
        return view('frontend.order-confirmation', compact('order'));
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $cart = $this->cartService->getCart();
        $result = $this->couponService->validateCoupon($request->coupon_code, $cart->total);

        if (!$result['valid']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 422);
        }

        // Apply coupon to cart
        $cart->update([
            'coupon_code' => $result['coupon']->code,
            'discount_amount' => $result['discount']
        ]);

        return response()->json([
            'success' => true,
            'message' => $result['message'],
            'discount' => $result['discount'],
            'final_total' => $cart->final_total
        ]);
    }

    /**
     * Remove coupon from cart
     */
    public function removeCoupon()
    {
        $cart = $this->cartService->getCart();
        $cart->update([
            'coupon_code' => null,
            'discount_amount' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed'
        ]);
    }
}
