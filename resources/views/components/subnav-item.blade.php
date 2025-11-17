<a {{ $attributes->merge(['class' => "inline-flex items-center gap-2 whitespace-nowrap text-sm font-medium transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 w-full justify-start"]) }}>
    {{ $slot }}
</a>