@extends('layouts.app')
@section('title', 'Créer un QR Code')

@section('content')
<div class="mb-8 space-y-0.5">
    <h1 class="text-xl font-semibold tracking-tight">Ajouter un QR Code</h1>
</div>

<form method="POST" action="{{ route('qrcodes.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <x-form-label for="title" value="Titre" />
        <x-form-input id="title" placeholder="Titre" name="title" type="text" :value="old('title')" required />
    </div>
    <div id="fields-wrapper" class="space-y-2 mt-4">
        <x-form-label value="Contenu" />
        @php
        $oldFields = old('fields', $qrcode->fields ?? []);
        @endphp

        @if(!empty($oldFields))
        @foreach($oldFields as $i => $f)
        <div class="flex items-start space-x-2 field-row">
            <x-form-input name="fields[{{ $i }}][label]" placeholder="Titre" :value="$f['label'] ?? ''" />
            <x-form-input name="fields[{{ $i }}][value]" placeholder="Contenu" :value="$f['value'] ?? ''" />
            <x-form-button type="button" design="danger-bordered" class="remove-field">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
                <span class="sr-only">Supprimer</span>
            </x-form-button>
        </div>
        @endforeach
        @else
        <div class="flex items-start space-x-2 field-row">
            <x-form-input name="fields[0][label]" placeholder="Titre" />
            <x-form-input name="fields[0][value]" placeholder="Contenu" />
            <x-form-button type="button" design="danger-bordered" class="remove-field">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>
                <span class="sr-only">Supprimer</span>
            </x-form-button>
        </div>
        @endif
    </div>
    <x-form-button type="button" design="bordered" id="add-field">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
        Ajouter un champ
    </x-form-button>
    <div class="mt-4">
        <x-form-button type="submit">
            Sauvegarder
        </x-form-button>
    </div>
</form>

<div id="field-template" class="hidden">
    <div class="flex items-start space-x-2 field-row">
        <x-form-input name="fields[__INDEX__][label]" placeholder="Titre" />
        <x-form-input name="fields[__INDEX__][value]" placeholder="Contenu" />
        <x-form-button type="button" design="danger-bordered" class="remove-field">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg>
            <span class="sr-only">Supprimer</span>
        </x-form-button>
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('fields-wrapper');
        if (e.target && e.target.id === 'add-field') {
            const index = wrapper.children.length;
            const template = document.getElementById('field-template').innerHTML;
            const div = document.createElement('div');
            div.innerHTML = template.replace(/__INDEX__/g, index);
            wrapper.appendChild(div.firstElementChild);
        }

        const removeBtn = e.target.closest('.remove-field');
        if (removeBtn) {
            const row = removeBtn.closest('.field-row');
            row?.remove();

            Array.from(wrapper.children).forEach((child, i) => {
                const label = child.querySelector('input[name$="[label]"]');
                const value = child.querySelector('input[name$="[value]"]');
                if (label) label.setAttribute('name', `fields[${i}][label]`);
                if (value) value.setAttribute('name', `fields[${i}][value]`);
            });
        }
    });
</script>
@endsection