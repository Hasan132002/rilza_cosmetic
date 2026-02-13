@props(['product'])

@if($product->variants && $product->variants->count() > 0)
<div class="variant-selector mb-6" x-data="variantSelector()">
    <!-- Variant Label -->
    <div class="mb-4">
        <label class="block text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <i class="fas fa-palette text-pink-600"></i>
            <span>Select Shade/Variant</span>
            <span class="text-pink-600" x-show="selectedVariant" x-text="selectedVariantName"></span>
        </label>
    </div>

    <!-- Variant Options -->
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
        @foreach($product->variants as $variant)
        <button
            type="button"
            @click="selectVariant({{ $variant->id }}, '{{ $variant->variant_name }}', {{ $variant->final_price }}, {{ $variant->stock_quantity }}, '{{ $variant->image ? asset('storage/' . $variant->image) : '' }}')"
            :class="selectedVariant === {{ $variant->id }} ? 'ring-4 ring-pink-500 scale-110' : 'ring-2 ring-gray-200 hover:ring-pink-300'"
            class="variant-option group relative overflow-hidden rounded-xl transition-all duration-300 transform hover:scale-105 cursor-pointer bg-white dark:bg-gray-800 shadow-lg"
            :disabled="!{{ $variant->stock_quantity > 0 ? 'true' : 'false' }}"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100">

            <!-- Variant Image or Color -->
            <div class="aspect-square p-2">
                @if($variant->image)
                <img src="{{ asset('storage/' . $variant->image) }}"
                     alt="{{ $variant->variant_name }}"
                     class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform duration-300">
                @else
                <!-- Color swatch placeholder -->
                <div class="w-full h-full rounded-lg {{ $variant->color_code ?? 'bg-gradient-to-br from-pink-400 to-purple-400' }} group-hover:scale-110 transition-transform duration-300"></div>
                @endif
            </div>

            <!-- Variant Name -->
            <div class="px-2 py-1 text-center">
                <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">
                    {{ $variant->variant_name }}
                </p>
                @if($variant->price_adjustment != 0)
                <p class="text-xs text-pink-600 font-bold">
                    {{ $variant->price_adjustment > 0 ? '+' : '' }}Rs {{ number_format($variant->price_adjustment, 0) }}
                </p>
                @endif
            </div>

            <!-- Selected Checkmark -->
            <div x-show="selectedVariant === {{ $variant->id }}"
                 x-transition
                 class="absolute top-1 right-1 w-6 h-6 bg-pink-600 rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-check text-white text-xs"></i>
            </div>

            <!-- Out of Stock Overlay -->
            @if($variant->stock_quantity == 0)
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <span class="text-white text-xs font-bold">Out</span>
            </div>
            @endif

            <!-- Hover Glow Effect -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-xl"
                 style="box-shadow: inset 0 0 20px rgba(236, 72, 153, 0.3);"></div>
        </button>
        @endforeach
    </div>

    <!-- Selected Variant Info -->
    <div x-show="selectedVariant"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="mt-4 p-4 bg-gradient-to-r from-pink-50 to-purple-50 dark:from-pink-900/20 dark:to-purple-900/20 rounded-xl border-2 border-pink-200 dark:border-pink-800">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Selected Variant:</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white" x-text="selectedVariantName"></p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Price:</p>
                <p class="text-2xl font-bold text-pink-600" x-text="'Rs ' + selectedVariantPrice.toLocaleString()"></p>
            </div>
        </div>
        <div class="mt-2 flex items-center gap-2" x-show="selectedVariantStock > 0">
            <i class="fas fa-check-circle text-green-600"></i>
            <span class="text-sm font-semibold text-green-600" x-text="selectedVariantStock + ' in stock'"></span>
        </div>
    </div>

    <!-- Hidden inputs for form submission -->
    <input type="hidden" name="variant_id" x-model="selectedVariant">
    <input type="hidden" name="variant_price" x-model="selectedVariantPrice">
</div>

<script>
function variantSelector() {
    return {
        selectedVariant: null,
        selectedVariantName: '',
        selectedVariantPrice: 0,
        selectedVariantStock: 0,
        selectedVariantImage: '',

        selectVariant(id, name, price, stock, image) {
            // Animate selection
            this.selectedVariant = id;
            this.selectedVariantName = name;
            this.selectedVariantPrice = price;
            this.selectedVariantStock = stock;
            this.selectedVariantImage = image;

            // Update main product price display
            const priceElement = document.querySelector('.product-price-display');
            if (priceElement) {
                priceElement.classList.add('animate-price-change');
                setTimeout(() => {
                    priceElement.textContent = 'Rs ' + price.toLocaleString();
                    priceElement.classList.remove('animate-price-change');
                }, 300);
            }

            // Update main product image if variant has image
            if (image) {
                const mainImage = document.querySelector('.product-main-image');
                if (mainImage) {
                    mainImage.classList.add('opacity-0');
                    setTimeout(() => {
                        mainImage.src = image;
                        mainImage.classList.remove('opacity-0');
                    }, 200);
                }
            }

            // Show success feedback
            if (window.toastSuccess) {
                toastSuccess(`${name} selected!`);
            }

            // Trigger confetti effect
            this.triggerConfetti();
        },

        triggerConfetti() {
            // Mini confetti burst
            const colors = ['#ec4899', '#f472b6', '#a855f7', '#c084fc'];
            for (let i = 0; i < 8; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.left = '50%';
                confetti.style.top = '30%';
                confetti.style.width = '6px';
                confetti.style.height = '6px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.borderRadius = '50%';
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';
                document.body.appendChild(confetti);

                const angle = (Math.PI * 2 * i) / 8;
                const velocity = 30 + Math.random() * 20;
                const vx = Math.cos(angle) * velocity;
                const vy = Math.sin(angle) * velocity;

                let posX = 0, posY = 0, opacity = 1;
                const animate = () => {
                    posX += vx * 0.016;
                    posY += vy * 0.016 + 20 * 0.016;
                    opacity -= 0.02;

                    confetti.style.transform = `translate(${posX}px, ${posY}px)`;
                    confetti.style.opacity = opacity;

                    if (opacity > 0) {
                        requestAnimationFrame(animate);
                    } else {
                        confetti.remove();
                    }
                };
                animate();
            }
        }
    }
}
</script>

<style>
    .variant-option {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .variant-option:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @keyframes priceChange {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); color: #ec4899; }
    }

    .animate-price-change {
        animation: priceChange 0.5s ease-in-out;
    }

    .product-main-image {
        transition: opacity 0.3s ease-in-out;
    }

    /* Pulse animation for selected variant */
    @keyframes pulse-ring {
        0% {
            box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(236, 72, 153, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(236, 72, 153, 0);
        }
    }

    .variant-option[aria-selected="true"] {
        animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }
</style>
@endif
