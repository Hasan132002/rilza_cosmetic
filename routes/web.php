<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ComparisonController;
use App\Http\Controllers\Frontend\OffersController;
use App\Http\Controllers\Frontend\TrackOrderController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\BusinessRegistrationController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\OrderController;
use Illuminate\Support\Facades\Route;

// Language Switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Sitemap & Robots
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function() {
    $content = "User-agent: *\nAllow: /\n\nSitemap: " . route('sitemap');
    return response($content, 200)->header('Content-Type', 'text/plain');
})->name('robots');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('category');
Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product');

// API Routes for AJAX
Route::get('/api/product/{id}', [FrontendProductController::class, 'apiShow']);
Route::post('/api/products/{id}/calculate-b2b-savings', function($id) {
    $product = \App\Models\Product::with('b2bPricing')->findOrFail($id);
    $quantity = request('quantity', 10);

    if (!$product->b2bPricing) {
        return response()->json(['error' => 'B2B pricing not available'], 404);
    }

    $b2bPrice = $product->b2bPricing;
    $retailPrice = $product->base_price;

    // Calculate price based on quantity
    $wholesalePrice = $b2bPrice->wholesale_price;
    if ($quantity >= $b2bPrice->bulk_tier_3_qty) {
        $wholesalePrice = $b2bPrice->bulk_tier_3_price;
        $tier = 'Tier 3 (200+)';
    } elseif ($quantity >= $b2bPrice->bulk_tier_2_qty) {
        $wholesalePrice = $b2bPrice->bulk_tier_2_price;
        $tier = 'Tier 2 (100+)';
    } elseif ($quantity >= $b2bPrice->bulk_tier_1_qty) {
        $wholesalePrice = $b2bPrice->bulk_tier_1_price;
        $tier = 'Tier 1 (50+)';
    } else {
        $tier = 'Base Wholesale';
    }

    $retailTotal = $retailPrice * $quantity;
    $wholesaleTotal = $wholesalePrice * $quantity;
    $savings = $retailTotal - $wholesaleTotal;
    $savingsPercent = ($savings / $retailTotal) * 100;

    return response()->json([
        'success' => true,
        'quantity' => $quantity,
        'tier' => $tier,
        'retail_price' => $retailPrice,
        'wholesale_price' => $wholesalePrice,
        'retail_total' => $retailTotal,
        'wholesale_total' => $wholesaleTotal,
        'savings' => $savings,
        'savings_percent' => round($savingsPercent, 1)
    ]);
});

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes (Login controlled by admin setting)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');

// Order confirmation (always requires auth)
Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');

// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Offers & Discounts
Route::get('/offers', [OffersController::class, 'index'])->name('offers');

// Order Tracking
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track-order');
Route::post('/track-order', [TrackOrderController::class, 'track'])->name('track-order.track');

// B2B Registration Routes
Route::get('/register/business', [BusinessRegistrationController::class, 'showRegistrationForm'])->name('business.register');
Route::post('/register/business', [BusinessRegistrationController::class, 'register'])->name('business.register.submit');
Route::get('/register/business/pending', [BusinessRegistrationController::class, 'pending'])->name('business.pending');

// Static Pages
Route::get('/about', fn() => view('frontend.pages.about'))->name('about');
Route::get('/contact', fn() => view('frontend.pages.contact'))->name('contact');
Route::get('/faq', fn() => view('frontend.pages.faq'))->name('faq');
Route::get('/privacy', fn() => view('frontend.pages.privacy'))->name('privacy');
Route::get('/terms', fn() => view('frontend.pages.terms'))->name('terms');
Route::get('/shipping', fn() => view('frontend.pages.shipping'))->name('shipping');
Route::get('/returns', fn() => view('frontend.pages.returns'))->name('returns');
Route::get('/customer-service', fn() => view('frontend.pages.customer-service'))->name('customer-service');
Route::get('/ingredients-safety', fn() => view('frontend.pages.ingredients-safety'))->name('ingredients-safety');
Route::get('/announcements', function() {
    $announcements = \App\Models\Announcement::where('is_active', true)
        ->orderBy('start_date', 'desc')
        ->paginate(12);
    return view('frontend.pages.announcements', compact('announcements'));
})->name('announcements');

// Dynamic Pages (CMS)
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/dashboard', function () {
    // Redirect based on user role
    if (auth()->user()->hasRole('super_admin')) {
        return redirect()->route('admin.super.dashboard');
    }
    if (auth()->user()->hasAnyRole(['admin', 'staff'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('account.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Account
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Frontend\AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [\App\Http\Controllers\Frontend\AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [\App\Http\Controllers\Frontend\AccountController::class, 'orderDetails'])->name('order.details');

        // Addresses
        Route::resource('addresses', AddressController::class)->except(['show']);
        Route::patch('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

        // Reviews
        Route::get('/reviews', [ReviewController::class, 'myReviews'])->name('reviews');
    });

    // Order Management Routes
    Route::prefix('orders')->name('order.')->group(function () {
        Route::get('/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('invoice');
        Route::post('/{order}/reorder', [OrderController::class, 'reorder'])->name('reorder');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Product Reviews
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review.store');

    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/add', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('remove');
        Route::post('/check', [WishlistController::class, 'check'])->name('check');
    });

    // Product Comparison Routes
    Route::prefix('compare')->name('compare.')->group(function () {
        Route::get('/', [ComparisonController::class, 'index'])->name('index');
        Route::post('/add', [ComparisonController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [ComparisonController::class, 'remove'])->name('remove');
        Route::post('/clear', [ComparisonController::class, 'clear'])->name('clear');
    });
});

require __DIR__.'/auth.php';
