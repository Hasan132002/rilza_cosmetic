<!-- Cart Sidebar Component -->
<div id="cart-sidebar" class="fixed right-0 top-0 h-full w-full max-w-md bg-white dark:bg-gray-900 shadow-2xl transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
    <!-- Header -->
    <div class="gradient-pink text-white px-6 py-6 flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <i class="fas fa-shopping-bag text-2xl"></i>
            <div>
                <h2 class="text-xl font-bold">Your Cart</h2>
                <p class="text-sm text-pink-100"><span id="sidebar-cart-count">0</span> items</p>
            </div>
        </div>
        <button onclick="toggleCartSidebar()" class="text-white hover:bg-pink-700 w-10 h-10 rounded-lg flex items-center justify-center transition-all">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Cart Items Container -->
    <div id="cart-items-container" class="flex-1 overflow-y-auto px-6 py-6 space-y-4">
        <!-- Items will be loaded here -->
        <div class="flex flex-col items-center justify-center h-full py-12">
            <i class="fas fa-shopping-bag text-6xl text-gray-200 dark:text-gray-700 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-center">Your cart is empty</p>
        </div>
    </div>

    <!-- Subtotal Section -->
    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 space-y-3 bg-gray-50 dark:bg-gray-800">
        <div class="flex justify-between items-center text-lg">
            <span class="text-gray-700 dark:text-gray-300 font-semibold">Subtotal:</span>
            <span class="font-bold text-pink-600 text-xl" id="sidebar-cart-total">Rs 0</span>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 text-center">Shipping & taxes calculated at checkout</p>
    </div>

    <!-- Action Buttons -->
    <div class="px-6 py-6 space-y-3 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('cart') }}" onclick="toggleCartSidebar()" class="w-full gradient-pink text-white py-3 rounded-xl font-bold text-center block hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
            <i class="fas fa-eye"></i>View Full Cart
        </a>
        <a href="{{ route('checkout') }}" onclick="toggleCartSidebar()" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-bold text-center block hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
            <i class="fas fa-lock"></i>Proceed to Checkout
        </a>
        <button onclick="toggleCartSidebar()" class="w-full text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white py-3 rounded-xl font-semibold border-2 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
            Continue Shopping
        </button>
    </div>
</div>

<!-- Overlay -->
<div id="cart-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 invisible transition-all duration-300 z-40" onclick="toggleCartSidebar()"></div>

<script>
    function toggleCartSidebar() {
        const sidebar = document.getElementById('cart-sidebar');
        const overlay = document.getElementById('cart-overlay');

        sidebar.classList.toggle('translate-x-full');
        overlay.classList.toggle('opacity-0');
        overlay.classList.toggle('invisible');
    }

    function updateCartSidebar(cartData) {
        const container = document.getElementById('cart-items-container');
        const countBadge = document.getElementById('sidebar-cart-count');
        const totalDisplay = document.getElementById('sidebar-cart-total');

        countBadge.textContent = cartData.cart_count;
        totalDisplay.textContent = 'Rs ' + formatCurrency(cartData.cart_total);

        if (cartData.cart_items.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full py-12">
                    <i class="fas fa-shopping-bag text-6xl text-gray-200 dark:text-gray-700 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Your cart is empty</p>
                </div>
            `;
            return;
        }

        container.innerHTML = cartData.cart_items.map(item => `
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover:shadow-md transition-shadow border border-gray-100 dark:border-gray-700">
                <!-- Product Image & Info -->
                <div class="flex gap-4 mb-4">
                    <div class="flex-shrink-0">
                        ${item.product_image ? `
                            <img src="${item.product_image}"
                                 alt="${item.product_name}"
                                 class="w-20 h-20 object-cover rounded-lg shadow-sm">
                        ` : `
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/20 dark:to-purple-900/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-2xl text-gray-300"></i>
                            </div>
                        `}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">
                            ${item.product_name}
                        </h4>
                        ${item.variant_name ? `<p class="text-xs text-pink-600 dark:text-pink-400 mt-1">${item.variant_name}</p>` : ''}
                        <p class="text-lg font-bold text-pink-600 mt-2">Rs ${formatCurrency(item.product_price)}</p>
                    </div>
                </div>

                <!-- Quantity Control -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                        <button onclick="updateCartItemQty(${item.id}, ${item.quantity - 1})"
                                class="w-7 h-7 rounded flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all text-gray-600 dark:text-gray-300">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="w-8 text-center font-semibold text-gray-900 dark:text-white">${item.quantity}</span>
                        <button onclick="updateCartItemQty(${item.id}, ${item.quantity + 1})"
                                class="w-7 h-7 rounded flex items-center justify-center hover:bg-pink-500 hover:text-white transition-all text-gray-600 dark:text-gray-300">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    <span class="font-bold text-gray-900 dark:text-white">Rs ${formatCurrency(item.item_total)}</span>
                </div>

                <!-- Remove Button -->
                <button onclick="removeFromCartSidebar(${item.id})"
                        class="w-full py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors text-sm font-semibold">
                    <i class="fas fa-trash mr-2"></i>Remove
                </button>
            </div>
        `).join('');
    }

    function updateCartItemQty(itemId, newQty) {
        if (newQty < 1) {
            removeFromCartSidebar(itemId);
            return;
        }

        fetch('{{ route("cart.update", ":id") }}'.replace(':id', itemId), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to update quantity');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCartSidebar(data);
                updateHeaderCartBadge(data.cart_count);
                showNotification('Quantity updated', 'success');
            } else {
                showNotification(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update quantity', 'error');
        });
    }

    function removeFromCartSidebar(itemId) {
        if (!confirm('Are you sure you want to remove this item?')) return;

        fetch('{{ route("cart.remove", ":id") }}'.replace(':id', itemId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to remove item');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCartSidebar(data);
                updateHeaderCartBadge(data.cart_count);
                showNotification('Item removed from cart', 'success');
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to remove item', 'error');
        });
    }

    function formatCurrency(amount) {
        return Number(amount).toLocaleString('en-PK');
    }

    function updateHeaderCartBadge(count) {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = count;
            if (count === 0) {
                badge.classList.add('hidden');
            } else {
                badge.classList.remove('hidden');
            }
        }
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-24 right-6 px-6 py-4 rounded-xl shadow-xl z-[60] animation-slide-in flex items-center gap-3 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };

        notification.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span>`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    // Reload sidebar after adding items
    function reloadCartSidebar() {
        location.reload();
    }
</script>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animation-slide-in {
        animation: slideIn 0.3s ease-out;
    }
</style>
