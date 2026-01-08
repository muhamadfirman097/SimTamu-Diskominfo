@props(['active'])

@php
$baseClasses = 'flex items-center px-2 py-2 text-sm font-medium rounded-md group transition-all duration-200';
$activeClasses = 'text-white bg-gray-900';
$inactiveClasses = 'text-gray-300 hover:bg-gray-700 hover:text-white';

$classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} :class="isSidebarExpanded ? 'justify-start' : 'justify-center'">
    {{ $slot }}
</a>
