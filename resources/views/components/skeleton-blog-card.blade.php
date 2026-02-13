{{-- Skeleton Loader for Blog Card --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden animate-pulse">
    <!-- Blog Image Skeleton -->
    <div class="relative h-56 bg-gradient-to-br from-gray-200 via-gray-300 to-gray-200 dark:from-gray-700 dark:via-gray-600 dark:to-gray-700 bg-[length:200%_200%] animate-shimmer">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-24 h-24 bg-gray-300 dark:bg-gray-600 rounded-lg"></div>
        </div>
    </div>

    <!-- Blog Content Skeleton -->
    <div class="p-6 space-y-4">
        <!-- Date & Category -->
        <div class="flex items-center gap-2">
            <div class="h-4 bg-pink-200 dark:bg-pink-900 rounded w-24"></div>
            <div class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
        </div>

        <!-- Title -->
        <div class="space-y-2">
            <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded w-full"></div>
            <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded w-4/5"></div>
        </div>

        <!-- Excerpt -->
        <div class="space-y-2">
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
        </div>

        <!-- Read More Button -->
        <div class="h-10 bg-gradient-to-r from-pink-200 to-purple-200 dark:from-pink-900 dark:to-purple-900 rounded-lg w-32"></div>
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
