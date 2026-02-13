{{-- Skeleton Loader for Category Card --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden animate-pulse">
    <!-- Category Image Skeleton -->
    <div class="relative h-48 bg-gradient-to-br from-pink-100 via-purple-100 to-pink-100 dark:from-pink-900 dark:via-purple-900 dark:to-pink-900 bg-[length:200%_200%] animate-shimmer">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-20 h-20 bg-white/30 dark:bg-gray-700/30 rounded-full"></div>
        </div>
    </div>

    <!-- Category Name Skeleton -->
    <div class="p-6 space-y-3">
        <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded w-3/4 mx-auto"></div>
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/2 mx-auto"></div>
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
