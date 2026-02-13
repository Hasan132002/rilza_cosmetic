{{-- Simple Text Skeleton Loader --}}
@props(['lines' => 3, 'width' => 'full'])

<div class="space-y-2 animate-pulse">
    @for($i = 0; $i < $lines; $i++)
        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded
            @if($i === $lines - 1 && $width !== 'full')
                w-{{ $width }}
            @else
                w-full
            @endif
        "></div>
    @endfor
</div>
