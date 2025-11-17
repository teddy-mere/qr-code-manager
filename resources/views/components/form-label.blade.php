@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm leading-none font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50']) }}>
    {{ $value ?? $slot }}
</label>