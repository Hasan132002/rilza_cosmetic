<x-frontend-layout title="Announcements">
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-pink-500 via-purple-500 to-pink-500 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    <i class="fas fa-bullhorn mr-4"></i>Announcements
                </h1>
                <p class="text-xl md:text-2xl text-pink-100">
                    Stay updated with our latest news, offers, and updates
                </p>
            </div>
        </div>
    </section>

    <!-- Announcements Grid -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if($announcements->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($announcements as $announcement)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden hover-lift group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Announcement Header with Color -->
                        <div class="h-3" style="background-color: {{ $announcement->background_color }}"></div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Date Badge -->
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ $announcement->start_date->format('M d, Y') }}</span>
                                </div>
                                @if($announcement->is_new)
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                    <i class="fas fa-star"></i> NEW
                                </span>
                                @endif
                            </div>

                            <!-- Message -->
                            <div class="mb-6">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-pink-600 transition-colors">
                                    {{ $announcement->message }}
                                </p>

                                @if($announcement->description)
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {{ Str::limit($announcement->description, 150) }}
                                </p>
                                @endif
                            </div>

                            <!-- Link Button -->
                            @if($announcement->link_url && $announcement->link_text)
                            <a href="{{ $announcement->link_url }}"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transition-all transform hover:scale-105 group">
                                <span>{{ $announcement->link_text }}</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            @endif

                            <!-- Duration Info -->
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-2">
                                        <i class="fas fa-clock"></i>
                                        <span>Valid till {{ $announcement->end_date->format('M d, Y') }}</span>
                                    </span>
                                    @if($announcement->end_date->isFuture())
                                    <span class="text-green-600 font-semibold flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $announcements->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20" data-aos="fade-up">
                    <div class="inline-block p-8 bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/20 dark:to-purple-900/20 rounded-full mb-6">
                        <i class="fas fa-bullhorn text-6xl text-pink-500"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">No Announcements Yet</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                        Check back later for updates, offers, and exciting news!
                    </p>
                    <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Continue Shopping</span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16">
        <div class="container mx-auto px-4 text-center" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-4">
                <i class="fas fa-envelope mr-3"></i>Never Miss an Update!
            </h2>
            <p class="text-xl mb-8 text-purple-100">
                Subscribe to our newsletter and be the first to know about new announcements, offers & products
            </p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="max-w-md mx-auto flex gap-3">
                @csrf
                <input type="email"
                       name="email"
                       placeholder="Enter your email"
                       required
                       class="flex-1 px-6 py-4 rounded-xl text-gray-900 focus:outline-none focus:ring-4 focus:ring-pink-300">
                <button type="submit"
                        class="bg-white text-pink-600 px-8 py-4 rounded-xl font-bold hover:bg-pink-50 transition-all transform hover:scale-105 whitespace-nowrap">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
</x-frontend-layout>
