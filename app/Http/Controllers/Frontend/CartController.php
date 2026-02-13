<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display cart page
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        $cart->load(['items.product.images', 'items.variant']);

        return view('frontend.cart', compact('cart'));
    }

    /**
     * Add item to cart (Form or AJAX)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $result = $this->cartService->addToCart(
            $request->product_id,
            $request->quantity ?? 1,
            $request->variant_id
        );

        // Handle AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            if ($result['success']) {
                $cart = $this->cartService->getCart();
                $cart->load(['items.product.images', 'items.variant']);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_total' => $this->cartService->getCartTotal(),
                    'cart_items' => $cart->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'product_slug' => $item->product->slug,
                            'quantity' => $item->quantity,
                            'product_price' => $item->product->final_price,
                            'product_image' => $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : null,
                            'variant_name' => $item->variant ? $item->variant->variant_name : null,
                            'item_total' => $item->product->final_price * $item->quantity,
                        ];
                    })->values()->toArray(),
                ]);
            }

            return response()->json($result, 422);
        }

        // Handle regular form submission
        if ($result['success']) {
            return redirect()->route('cart')->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->cartService->updateQuantity($id, $request->quantity);

        if ($request->ajax()) {
            if ($result['success']) {
                $cart = $this->cartService->getCart();
                $cart->load(['items.product.images', 'items.variant']);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_total' => $this->cartService->getCartTotal(),
                    'cart_items' => $cart->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'product_slug' => $item->product->slug,
                            'quantity' => $item->quantity,
                            'product_price' => $item->product->final_price,
                            'product_image' => $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : null,
                            'variant_name' => $item->variant ? $item->variant->variant_name : null,
                            'item_total' => $item->product->final_price * $item->quantity,
                        ];
                    })->values()->toArray(),
                ]);
            }

            return response()->json($result, 422);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $id)
    {
        $result = $this->cartService->removeItem($id);

        if ($request->ajax()) {
            if ($result['success']) {
                $cart = $this->cartService->getCart();
                $cart->load(['items.product.images', 'items.variant']);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'cart_count' => $this->cartService->getCartCount(),
                    'cart_total' => $this->cartService->getCartTotal(),
                    'cart_items' => $cart->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'product_slug' => $item->product->slug,
                            'quantity' => $item->quantity,
                            'product_price' => $item->product->final_price,
                            'product_image' => $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : null,
                            'variant_name' => $item->variant ? $item->variant->variant_name : null,
                            'item_total' => $item->product->final_price * $item->quantity,
                        ];
                    })->values()->toArray(),
                ]);
            }

            return response()->json($result, 422);
        }

        return back()->with('success', $result['message']);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->cartService->clearCart();
        return back()->with('success', 'Cart cleared successfully');
    }
}
