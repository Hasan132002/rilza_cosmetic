<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;

class CartApiController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getSidebarData()
    {
        $cart = $this->cartService->getCart();
        $cart->load(['items.product.images', 'items.variant']);

        $items = $cart->items->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_slug' => $item->product->slug,
                'product_image' => $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : null,
                'product_price' => $item->product->final_price,
                'quantity' => $item->quantity,
                'variant_name' => $item->variant ? $item->variant->variant_name : null,
                'item_total' => $item->product->final_price * $item->quantity,
            ];
        });

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartService->getCartCount(),
            'cart_total' => $this->cartService->getCartTotal(),
            'cart_items' => $items
        ]);
    }
}
