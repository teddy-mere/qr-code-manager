@props(['design' => ''])

@php
switch($design) {
    case 'bordered':
        $classes = 'bg-transparent border border-input text-foreground hover:bg-accent hover:text-accent-foreground';
        break;
    case 'inverse':
        $classes = 'bg-white hover:bg-white/90 dark:bg-gray-800 dark:hover:bg-gray-800/90';
        break;
    case 'inverse-bordered':
        $classes = 'bg-white hover:bg-white/90 border border-input dark:bg-background dark:border-(--color-background)';
        break;
    default:
        $classes = 'bg-primary text-primary-foreground hover:bg-primary/90';
}
@endphp

<a {!! $attributes->merge(['class' => 'inline-flex items-center justify-center gap-1 px-2 py-1 whitespace-nowrap rounded-md text-xs font-medium transition-[color,box-shadow] focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]' . ' ' . $classes]) !!}>
    {{ $slot }}
</a>