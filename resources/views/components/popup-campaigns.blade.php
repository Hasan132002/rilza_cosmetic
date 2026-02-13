@php
    $popups = \App\Models\PopupCampaign::active()->get();
    $popupsData = $popups->map(function($popup) {
        return [
            'id' => $popup->id,
            'delay' => $popup->delay_seconds,
            'show_on_exit' => $popup->show_on_exit,
            'frequency' => $popup->display_frequency,
        ];
    });
@endphp

@if($popups->count() > 0)
<div x-data="popupManager()" x-init="initPopups()">
    @foreach($popups as $popup)
    <div x-show="activePopup === '{{ $popup->id }}'"
         x-cloak
         @if($popup->show_on_exit)
         @mouseleave.document="showExitPopup('{{ $popup->id }}')"
         @endif
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 overflow-hidden"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Close Button -->
            <button @click="closePopup('{{ $popup->id }}')"
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 dark:bg-gray-700 rounded-full flex items-center justify-center hover:bg-white dark:hover:bg-gray-600 transition-colors shadow-lg">
                <i class="fas fa-times text-gray-700 dark:text-gray-300"></i>
            </button>

            <div class="grid grid-cols-1 @if($popup->image) md:grid-cols-2 @endif">
                @if($popup->image)
                <!-- Image Section -->
                <div class="h-64 md:h-full">
                    <img src="{{ $popup->image_url }}" alt="{{ $popup->title }}" class="w-full h-full object-cover">
                </div>
                @endif

                <!-- Content Section -->
                <div class="p-8 md:p-12 @if(!$popup->image) col-span-1 @endif">
                    @if($popup->type === 'discount' && $popup->coupon_code)
                    <div class="inline-block mb-4 px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full text-sm font-bold">
                        <i class="fas fa-tag mr-2"></i>Special Offer
                    </div>
                    @elseif($popup->type === 'newsletter')
                    <div class="inline-block mb-4 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full text-sm font-bold">
                        <i class="fas fa-envelope mr-2"></i>Newsletter
                    </div>
                    @endif

                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $popup->title }}
                    </h3>

                    @if($popup->description)
                    <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                        {{ $popup->description }}
                    </p>
                    @endif

                    @if($popup->type === 'discount' && $popup->coupon_code)
                    <div class="mb-6 p-4 bg-pink-50 dark:bg-gray-700 border-2 border-dashed border-pink-300 dark:border-pink-700 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Use Coupon Code:</p>
                        <div class="flex items-center justify-between">
                            <code class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ $popup->coupon_code }}</code>
                            <button onclick="navigator.clipboard.writeText('{{ $popup->coupon_code }}')"
                                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors text-sm">
                                <i class="fas fa-copy mr-2"></i>Copy
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($popup->type === 'newsletter')
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex gap-2">
                            <input type="email" name="email" placeholder="Enter your email" required
                                   class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 dark:bg-gray-700 dark:text-white">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                                Subscribe
                            </button>
                        </div>
                    </form>
                    @endif

                    @if($popup->button_text && $popup->button_link)
                    <a href="{{ $popup->button_link }}"
                       @click="closePopup('{{ $popup->id }}')"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-xl font-bold hover:shadow-xl transition-all transform hover:scale-105">
                        {{ $popup->button_text }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    @endif

                    <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        <button @click="closePopup('{{ $popup->id }}', true)" class="underline hover:text-gray-700 dark:hover:text-gray-300">
                            Don't show this again
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
function popupManager() {
    return {
        activePopup: null,
        popups: @json($popupsData),

        initPopups() {
            // Check each popup
            this.popups.forEach(popup => {
                // Check if popup should be shown based on frequency
                const lastShown = localStorage.getItem(`popup_${popup.id}_last_shown`);
                const shouldShow = !lastShown || this.shouldShowAgain(lastShown, popup.frequency);

                if (shouldShow && !popup.show_on_exit) {
                    // Show popup after delay
                    setTimeout(() => {
                        if (!this.activePopup) {
                            this.showPopup(popup.id);
                        }
                    }, popup.delay * 1000);
                }
            });
        },

        shouldShowAgain(lastShown, frequency) {
            const daysSinceShown = (Date.now() - parseInt(lastShown)) / (1000 * 60 * 60 * 24);
            return daysSinceShown >= frequency;
        },

        showPopup(id) {
            this.activePopup = id.toString();
            localStorage.setItem(`popup_${id}_last_shown`, Date.now().toString());
        },

        showExitPopup(id) {
            const lastShown = localStorage.getItem(`popup_${id}_last_shown`);
            if (!this.activePopup && !lastShown) {
                this.showPopup(id);
            }
        },

        closePopup(id, permanent = false) {
            this.activePopup = null;
            if (permanent) {
                localStorage.setItem(`popup_${id}_permanent_hide`, 'true');
            }
        }
    }
}
</script>
@endif

<style>
    [x-cloak] { display: none !important; }
</style>
