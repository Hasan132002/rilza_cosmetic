<x-frontend-layout title="FAQ">
    <div class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h1 class="text-5xl font-bold mb-6">Frequently Asked Questions</h1>
                    <p class="text-xl text-gray-600">Find answers to common questions</p>
                </div>

                <div class="space-y-4" x-data="{ open: null }">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                        <button @click="open = open === 1 ? null : 1" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-bold text-lg">How do I place an order?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 1 }"></i>
                        </button>
                        <div x-show="open === 1" x-collapse class="px-8 pb-6 text-gray-600">
                            Browse products, add to cart, proceed to checkout, fill in shipping details, and place your order with Cash on Delivery payment.
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <button @click="open = open === 2 ? null : 2" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-bold text-lg">What payment methods do you accept?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 2 }"></i>
                        </button>
                        <div x-show="open === 2" x-collapse class="px-8 pb-6 text-gray-600">
                            Currently, we accept Cash on Delivery (COD). Pay when you receive your order at your doorstep.
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <button @click="open = open === 3 ? null : 3" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-bold text-lg">How long does delivery take?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 3 }"></i>
                        </button>
                        <div x-show="open === 3" x-collapse class="px-8 pb-6 text-gray-600">
                            Delivery typically takes 3-5 business days within major cities and 5-7 days for other areas.
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                        <button @click="open = open === 4 ? null : 4" class="w-full px-8 py-6 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-bold text-lg">Are products authentic?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 4 }"></i>
                        </button>
                        <div x-show="open === 4" x-collapse class="px-8 pb-6 text-gray-600">
                            Yes! All our products are 100% authentic and sourced directly from authorized distributors.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
