<!-- Quick View Modal -->
<div id="quick-view-modal" class="fixed inset-0 z-[999] hidden items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300"
         onclick="closeQuickView()"
         id="quick-view-backdrop"></div>

    <!-- Modal Content -->
    <div class="relative z-50 w-full max-w-4xl">
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl max-w-4xl w-full max-h-[95vh] overflow-y-auto"
             id="quick-view-content"
             onclick="event.stopPropagation()">

            <!-- Close Button -->
            <button onclick="closeQuickView()"
                    class="absolute top-6 right-6 z-50 w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all shadow-lg">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Loading State -->
            <div id="quick-view-loader" class="flex items-center justify-center h-96">
                <div class="text-center">
                    <div class="inline-block">
                        <div class="w-12 h-12 border-4 border-pink-200 border-t-pink-500 rounded-full animate-spin"></div>
                    </div>
                    <p class="mt-4 text-gray-600 dark:text-gray-400 font-semibold">Loading product...</p>
                </div>
            </div>

            <!-- Content Container -->
            <div id="quick-view-body" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Product Images -->
                    <div class="flex flex-col">
                        <!-- Main Image -->
                        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-pink-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 mb-4">
                            <img id="qv-main-image"
                                 src=""
                                 alt="Product"
                                 class="w-full h-96 object-cover">
                            <!-- Sale Badge -->
                            <div id="qv-sale-badge" class="hidden absolute bottom-4 right-4">
                                <div class="bg-red-500 text-white w-16 h-16 rounded-full flex flex-col items-center justify-center font-bold shadow-xl">
                                    <span class="text-xs">SAVE</span>
                                    <span id="qv-discount-pct" class="text-lg">0%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div id="qv-thumbnails" class="flex gap-3 overflow-x-auto pb-2">
                            <!-- Thumbnails will be injected here -->
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col">
                        <!-- Category and Title -->
                        <div class="mb-4">
                            <p id="qv-category" class="text-xs font-semibold text-pink-600 dark:text-pink-400 mb-2 uppercase tracking-wide"></p>
                            <h2 id="qv-title" class="text-3xl font-bold text-gray-900 dark:text-white mb-3"></h2>
                            <div id="qv-rating" class="flex items-center gap-2 mb-4">
                                <!-- Stars will be injected -->
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-pink-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-xl">
                            <div id="qv-price" class="flex items-center gap-3">
                                <!-- Price will be injected -->
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">About this product</h4>
                            <p id="qv-description" class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed"></p>
                        </div>

                        <!-- Stock Status -->
                        <div id="qv-stock-status" class="mb-6 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700/50 rounded-lg">
                            <span id="qv-stock-text" class="text-sm text-yellow-800 dark:text-yellow-200 flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                <span></span>
                            </span>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Quantity</label>
                            <div class="flex items-center gap-4 bg-gray-100 dark:bg-gray-800 rounded-xl p-2 w-fit">
                                <button onclick="decreaseQuantity()" class="w-10 h-10 text-pink-600 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input id="qv-quantity" type="number" value="1" min="1" class="w-12 text-center bg-transparent font-bold text-gray-900 dark:text-white outline-none">
                                <button onclick="increaseQuantity()" class="w-10 h-10 text-pink-600 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 mb-6">
                            <!-- Add to Cart -->
                            <button id="qv-add-to-cart-btn"
                                    onclick="addToCartFromModal()"
                                    class="flex-1 gradient-pink text-white py-3 rounded-xl font-bold hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>

                            <!-- Add to Wishlist -->
                            @auth
                            <button id="qv-wishlist-btn"
                                    onclick="addToWishlistFromModal()"
                                    class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl hover:bg-pink-500 hover:text-white transition-all flex items-center justify-center text-lg"
                                    title="Add to wishlist">
                                <i class="fas fa-heart wishlist-modal-icon"></i>
                            </button>
                            @endauth
                        </div>

                        <!-- View Full Details Button -->
                        <a id="qv-view-full-btn"
                           href="#"
                           class="text-center py-3 rounded-xl border-2 border-pink-600 text-pink-600 dark:text-pink-400 font-bold hover:bg-pink-50 dark:hover:bg-pink-900/20 transition-all">
                            View Full Details <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #quick-view-modal.show {
        display: block;
    }

    #quick-view-modal.show #quick-view-backdrop {
        animation: fadeIn 0.3s ease-out;
    }

    #quick-view-modal.show #quick-view-content {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .thumbnail-img {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }

    .thumbnail-img.active {
        border-color: #ec4899;
    }

    .thumbnail-img:hover {
        border-color: #f472b6;
    }
</style>

<script>
let currentProductData = null;

async function openQuickView(productId, event = null) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const modal = document.getElementById('quick-view-modal');
    const loader = document.getElementById('quick-view-loader');
    const body = document.getElementById('quick-view-body');

    // Show modal and loader
    modal.classList.add('show');
    modal.classList.remove('hidden');
    loader.style.display = 'flex';
    body.classList.add('hidden');

    // Disable body scroll
    document.body.style.overflow = 'hidden';

    try {
        // Fetch product data via AJAX
        const response = await fetch(`/api/product/${productId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to load product');

        const data = await response.json();
        currentProductData = data.product;

        // Populate modal with product data
        populateQuickViewModal(data.product);

        // Show body, hide loader
        loader.style.display = 'none';
        body.classList.remove('hidden');

        // Animate in
        setTimeout(() => {
            body.style.animation = 'slideUp 0.3s ease-out';
        }, 50);

    } catch (error) {
        console.error('Error loading product:', error);
        loader.innerHTML = `
            <div class="text-center">
                <i class="fas fa-exclamation-circle text-red-500 text-5xl mb-4"></i>
                <p class="text-gray-600 dark:text-gray-400 font-semibold">Failed to load product</p>
                <button onclick="closeQuickView()" class="mt-4 text-pink-600 hover:text-pink-700 font-medium">Close</button>
            </div>
        `;
    }
}

function populateQuickViewModal(product) {
    // Set title and category
    document.getElementById('qv-title').textContent = product.name;
    document.getElementById('qv-category').textContent = product.category?.name || 'Product';

    // Set main image
    const mainImage = product.images && product.images.length > 0
        ? `/storage/${product.images[0].image_path}`
        : '/images/placeholder.jpg';
    document.getElementById('qv-main-image').src = mainImage;

    // Set price
    const priceContainer = document.getElementById('qv-price');
    if (product.is_on_sale && product.discount_price) {
        priceContainer.innerHTML = `
            <span class="text-3xl font-bold text-pink-600">Rs ${product.discount_price.toLocaleString()}</span>
            <span class="text-lg text-gray-400 line-through">Rs ${product.base_price.toLocaleString()}</span>
        `;
        const saleBadge = document.getElementById('qv-sale-badge');
        saleBadge.classList.remove('hidden');
        document.getElementById('qv-discount-pct').textContent = product.discount_percentage + '%';
    } else {
        priceContainer.innerHTML = `<span class="text-3xl font-bold text-gray-900 dark:text-white">Rs ${product.base_price.toLocaleString()}</span>`;
    }

    // Set description
    document.getElementById('qv-description').textContent = product.short_description || product.description || 'No description available';

    // Set stock status
    const stockStatus = document.getElementById('qv-stock-status');
    const stockText = document.getElementById('qv-stock-text');
    if (product.stock_quantity === 0) {
        stockStatus.classList.add('bg-red-50', 'dark:bg-red-900/20', 'border-red-200', 'dark:border-red-700/50');
        stockStatus.classList.remove('bg-yellow-50', 'dark:bg-yellow-900/20', 'border-yellow-200', 'dark:border-yellow-700/50');
        stockText.classList.add('text-red-800', 'dark:text-red-200');
        stockText.classList.remove('text-yellow-800', 'dark:text-yellow-200');
        stockText.innerHTML = '<i class="fas fa-times-circle"></i><span>Out of Stock</span>';
        document.getElementById('qv-add-to-cart-btn').disabled = true;
        document.getElementById('qv-add-to-cart-btn').classList.add('opacity-50', 'cursor-not-allowed');
    } else if (product.stock_quantity <= 10) {
        stockText.innerHTML = `<i class="fas fa-exclamation-circle"></i><span>Only ${product.stock_quantity} left in stock!</span>`;
    } else {
        stockText.innerHTML = '<i class="fas fa-check-circle text-green-600"></i><span class="text-green-800 dark:text-green-200">In Stock</span>';
        stockStatus.classList.add('bg-green-50', 'dark:bg-green-900/20', 'border-green-200', 'dark:border-green-700/50');
        stockStatus.classList.remove('bg-yellow-50', 'dark:bg-yellow-900/20', 'border-yellow-200', 'dark:border-yellow-700/50');
    }

    // Set view full details link
    document.getElementById('qv-view-full-btn').href = `/product/${product.slug}`;

    // Populate thumbnails
    const thumbnailsContainer = document.getElementById('qv-thumbnails');
    thumbnailsContainer.innerHTML = '';
    if (product.images && product.images.length > 0) {
        product.images.forEach((image, index) => {
            const thumb = document.createElement('img');
            thumb.src = `/storage/${image.image_path}`;
            thumb.alt = `${product.name} - Image ${index + 1}`;
            thumb.className = 'thumbnail-img w-20 h-20 object-cover rounded-lg flex-shrink-0' + (index === 0 ? ' active' : '');
            thumb.onclick = () => changeMainImage(thumb.src, index);
            thumbnailsContainer.appendChild(thumb);
        });
    }

    // Check if in wishlist
    checkWishlistStatus(product.id);

    // Reset quantity
    document.getElementById('qv-quantity').value = 1;
}

function changeMainImage(src, index) {
    document.getElementById('qv-main-image').src = src;
    document.querySelectorAll('.thumbnail-img').forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}

async function checkWishlistStatus(productId) {
    if (!{{ auth()->check() ? 'true' : 'false' }}) return;

    try {
        const response = await fetch('{{ route("wishlist.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: productId })
        });

        const data = await response.json();
        const btn = document.getElementById('qv-wishlist-btn');
        const icon = btn.querySelector('.wishlist-modal-icon');

        if (data.in_wishlist) {
            btn.classList.add('bg-pink-500', 'text-white');
            btn.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            icon.classList.add('text-pink-500');
        } else {
            btn.classList.remove('bg-pink-500', 'text-white');
            btn.classList.add('bg-gray-200', 'dark:bg-gray-700');
            icon.classList.remove('text-pink-500');
        }
    } catch (error) {
        console.error('Error checking wishlist:', error);
    }
}

function increaseQuantity() {
    const input = document.getElementById('qv-quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('qv-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

async function addToCartFromModal() {
    if (!currentProductData) return;

    const quantity = parseInt(document.getElementById('qv-quantity').value);
    const btn = document.getElementById('qv-add-to-cart-btn');
    const originalContent = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const response = await fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: currentProductData.id,
                quantity: quantity
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Product added to cart!', 'success');
            updateHeaderCartBadge(data.cart_count);
            setTimeout(() => {
                closeQuickView();
            }, 1000);
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to add to cart', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    }
}

async function addToWishlistFromModal() {
    if (!currentProductData) return;

    const btn = document.getElementById('qv-wishlist-btn');
    const icon = btn.querySelector('.wishlist-modal-icon');
    const isInWishlist = btn.classList.contains('bg-pink-500');

    if (isInWishlist) {
        // Remove from wishlist
        removeFromWishlistFromModal();
        return;
    }

    try {
        const response = await fetch('{{ route("wishlist.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: currentProductData.id })
        });

        const data = await response.json();

        if (data.success || data.in_wishlist) {
            btn.classList.add('bg-pink-500', 'text-white');
            btn.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            icon.classList.add('text-pink-500', 'fill-current');
            updateWishlistBadge(data.wishlist_count);
            showNotification('Added to wishlist!', 'success');
        } else {
            showNotification(data.message || 'Failed to add to wishlist', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to update wishlist', 'error');
    }
}

async function removeFromWishlistFromModal() {
    if (!currentProductData) return;

    const btn = document.getElementById('qv-wishlist-btn');
    const icon = btn.querySelector('.wishlist-modal-icon');

    try {
        const response = await fetch(`{{ route("wishlist.remove", ":id") }}`.replace(':id', currentProductData.id), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            btn.classList.remove('bg-pink-500', 'text-white');
            btn.classList.add('bg-gray-200', 'dark:bg-gray-700');
            icon.classList.remove('text-pink-500', 'fill-current');
            updateWishlistBadge(data.wishlist_count);
            showNotification('Removed from wishlist', 'success');
        } else {
            showNotification(data.message || 'Failed to remove from wishlist', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Failed to update wishlist', 'error');
    }
}

function closeQuickView() {
    const modal = document.getElementById('quick-view-modal');
    modal.classList.remove('show');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    currentProductData = null;
}

// Close modal when pressing Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeQuickView();
    }
});
</script>
