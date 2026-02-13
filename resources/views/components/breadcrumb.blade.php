@props(['items' => []])

<nav class="py-4 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors">
                    <i class="fas fa-home"></i>
                    <span class="ml-2">Home</span>
                </a>
            </li>

            @foreach($items as $item)
            <li class="flex items-center space-x-2">
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                @if(isset($item['url']))
                <a href="{{ $item['url'] }}" class="text-gray-500 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors">
                    {{ $item['label'] }}
                </a>
                @else
                <span class="text-gray-700 dark:text-gray-300 font-medium">
                    {{ $item['label'] }}
                </span>
                @endif
            </li>
            @endforeach
        </ol>
    </div>
</nav>
