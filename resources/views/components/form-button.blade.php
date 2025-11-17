@props(['disabled' => false, 'design' => ''])

@php
switch($design) {
    case 'danger':
        $classes = 'bg-destructive text-white hover:bg-destructive/90';
        break;
    case 'bordered':
        $classes = 'bg-transparent border border-input text-foreground hover:bg-accent hover:text-accent-foreground';
        break;
    case 'danger-bordered':
        $classes = 'bg-transparent border border-destructive text-destructive hover:bg-destructive hover:text-white';
        break;
    default:
        $classes = 'bg-primary text-primary-foreground hover:bg-primary/90';
}
@endphp

<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'cursor-pointer inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] shadow-xs h-9 px-4 py-2' . ' ' . $classes]) !!}>
    {{ $slot }}
</button>