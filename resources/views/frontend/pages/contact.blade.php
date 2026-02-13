<x-frontend-layout title="Contact Us">
    <div class="py-20 bg-gradient-to-br from-pink-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h1 class="text-5xl font-bold mb-6">Contact Us</h1>
                    <p class="text-xl text-gray-600">We'd love to hear from you!</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="bg-white rounded-3xl shadow-2xl p-12" data-aos="fade-right">
                        <h2 class="text-3xl font-bold mb-8">Get in Touch</h2>
                        <form>
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Name</label>
                                    <input type="text" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Email</label>
                                    <input type="email" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2">Message</label>
                                    <textarea rows="5" class="w-full px-4 py-3 border-2 rounded-xl focus:border-pink-500"></textarea>
                                </div>
                                <button class="w-full gradient-pink text-white py-4 rounded-xl font-bold hover-lift">
                                    <i class="fas fa-paper-plane mr-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <div data-aos="fade-left">
                        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-6">
                            <h3 class="text-2xl font-bold mb-8">Contact Information</h3>
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 gradient-pink rounded-xl flex items-center justify-center"><i class="fas fa-envelope text-white"></i></div>
                                    <div>
                                        <p class="font-semibold">Email</p>
                                        <p class="text-gray-600">info@rizlacosmetics.com</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 gradient-purple rounded-xl flex items-center justify-center"><i class="fas fa-phone text-white"></i></div>
                                    <div>
                                        <p class="font-semibold">Phone</p>
                                        <p class="text-gray-600">+92 300 1234567</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 gradient-blue rounded-xl flex items-center justify-center"><i class="fas fa-map-marker-alt text-white"></i></div>
                                    <div>
                                        <p class="font-semibold">Address</p>
                                        <p class="text-gray-600">Karachi, Pakistan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl shadow-2xl p-8">
                            <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                            <div class="flex gap-4">
                                <a href="#" class="w-12 h-12 gradient-pink rounded-full flex items-center justify-center hover-lift"><i class="fab fa-facebook-f text-white"></i></a>
                                <a href="#" class="w-12 h-12 gradient-purple rounded-full flex items-center justify-center hover-lift"><i class="fab fa-instagram text-white"></i></a>
                                <a href="#" class="w-12 h-12 gradient-blue rounded-full flex items-center justify-center hover-lift"><i class="fab fa-twitter text-white"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
