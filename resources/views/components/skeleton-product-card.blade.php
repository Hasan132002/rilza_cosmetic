{{-- Skeleton Loader for Product Card --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden animate-pulse">
    <!-- Product Image Skeleton -->
    <div class="relative aspect-square bg-gradient-to-br from-gray-200 via-gray-300 to-gray-200 dark:from-gray-700 dark:via-gray-600 dark:to-gray-700 bg-[length:200%_200%] animate-shimmer">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
        </div>
    </div>

    <!-- Product Details Skeleton -->
    <div class="p-4 space-y-3">
        <!-- Category -->
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>

        <!-- Product Name -->
        <div class="space-y-2">
            <div class="h-5 bg-gray-300 dark:bg-gray-600 rounded w-4/5"></div>
            <div class="h-5 bg-gray-300 dark:bg-gray-600 rounded w-2/3"></div>
        </div>

        <!-- Rating -->
        <div class="flex items-center gap-2">
            <div class="flex gap-1">
                @for($i = 0; $i < 5; $i++)
                <div class="w-4 h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                @endfor
            </div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-12"></div>
        </div>

        <!-- Price -->
        <div class="flex items-center gap-2">
            <div class="h-6 bg-pink-200 dark:bg-pink-900 rounded w-20"></div>
            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
        </div>

        <!-- Add to Cart Button -->
        <div class="h-10 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-lg"></div>
    </div>
</div>

<style>
    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    .animate-shimmer {
        animation: shimmer 2s ease-in-out infinite;
    }
</style>
