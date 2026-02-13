<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get or create cart for current user/session
     */
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => Session::getId()]
            );
        }

        return Cart::firstOrCreate(
            ['session_id' => Session::getId()],
            ['user_id' => null]
        );
    }

    /**
     * Add product to cart
     */
    public function addToCart($productId, $quantity = 1, $variantId = null)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);

        // Check if user is B2B and enforce MOQ
        if (Auth::check() && Auth::user()->isB2BApproved()) {
            if ($product->isAvailableForB2B()) {
                $moq = $product->getB2BMinimumQuantity();

                // Check if item already exists in cart
                $cartItem = $cart->items()->where('product_id', $productId)
                    ->where('product_variant_id', $variantId)
                    ->first();

                $totalQuantity = $cartItem ? $cartItem->quantity + $quantity : $quantity;

                if ($totalQuantity < $moq) {
                    return [
                        'success' => false,
                        'message' => "Minimum order quantity for this product is {$moq} units. Please add at least {$moq} units to your cart.",
                        'moq' => $moq
                    ];
                }
            }
        }

        // Check stock
        if ($product->stock_quantity < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }

        // Check if item already exists in cart
        $cartItem = $cart->items()->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock_quantity < $newQuantity) {
                return ['success' => false, 'message' => 'Insufficient stock'];
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cart->items()->create([
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return ['success' => true, 'message' => 'Product added to cart!'];
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if ($quantity <= 0) {
            $cartItem->delete();
            return ['success' => true, 'message' => 'Item removed from cart'];
        }

        // Check if user is B2B and enforce MOQ
        if (Auth::check() && Auth::user()->isB2BApproved()) {
            $product = $cartItem->product;
            if ($product->isAvailableForB2B()) {
                $moq = $product->getB2BMinimumQuantity();

                if ($quantity < $moq) {
                    return [
                        'success' => false,
                        'message' => "Minimum order quantity for this product is {$moq} units.",
                        'moq' => $moq
                    ];
                }
            }
        }

        if ($cartItem->product->stock_quantity < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }

        $cartItem->update(['quantity' => $quantity]);
        return ['success' => true, 'message' => 'Cart updated'];
    }

    /**
     * Remove item from cart
     */
    public function removeItem($cartItemId)
    {
        CartItem::findOrFail($cartItemId)->delete();
        return ['success' => true, 'message' => 'Item removed from cart'];
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        return ['success' => true, 'message' => 'Cart cleared'];
    }

    /**
     * Get cart total
     */
    public function getCartTotal()
    {
        $cart = $this->getCart();
        return $cart->items->sum(function ($item) {
            return $item->product->final_price * $item->quantity;
        });
    }

    /**
     * Get cart item count
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        return $cart->items->sum('quantity');
    }

    /**
     * Migrate session cart to user cart on login/register
     */
    public function migrateSessionCartToUser()
    {
        if (!Auth::check()) return;

        $sessionId = Session::getId();
        $sessionCart = Cart::where('session_id', $sessionId)->whereNull('user_id')->first();

        if (!$sessionCart || $sessionCart->items->count() === 0) return;

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Transfer items from session cart to user cart
        foreach ($sessionCart->items as $item) {
            $existingItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->where('product_variant_id', $item->product_variant_id)
                ->first();

            if ($existingItem) {
                $existingItem->increment('quantity', $item->quantity);
            } else {
                $userCart->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                ]);
            }
        }

        // Delete session cart
        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}
