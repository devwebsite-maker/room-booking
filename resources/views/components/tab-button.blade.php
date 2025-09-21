@props(['name', 'activeTab', 'count' => 0])

@php
$baseClasses = 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out focus:outline-none';

$activeClasses = 'border-indigo-500 text-indigo-600 dark:text-indigo-400';

$inactiveClasses = 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:hover:text-gray-300';

$classes = $baseClasses . ' ' . ($activeTab === $name ? $activeClasses : $inactiveClasses);
@endphp

<button @click="activeTab = '{{ $name }}'" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    @if($count > 0)
        <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none rounded-full
                     bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
            {{ $count }}
        </span>
    @endif
</button>