@php
    $whatsappEnabled = \App\Models\Setting::get('whatsapp_enabled', '1');
    $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '+923001234567');
    $whatsappMessage = \App\Models\Setting::get('whatsapp_message', 'Hi! I would like to know more about your products.');
@endphp

@if($whatsappEnabled == '1')
<div class="fixed bottom-6 right-6 z-50" x-data="{ show: false }" x-init="setTimeout(() => show = true, 2000)">
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $whatsappNumber) }}?text={{ urlencode($whatsappMessage) }}"
       target="_blank"
       rel="noopener noreferrer"
       x-show="show"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 transform scale-50"
       x-transition:enter-end="opacity-100 transform scale-100"
       class="flex items-center justify-center w-16 h-16 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 group animate-bounce"
       title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp text-3xl group-hover:scale-110 transition-transform"></i>
        <span class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 rounded-full animate-ping"></span>
        <span class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 rounded-full"></span>
    </a>
</div>

<style>
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }
</style>
@endif
