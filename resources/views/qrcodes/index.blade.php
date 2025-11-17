@extends('layouts.app')
@section('title', 'QR Codes')

@section('content')
<div class="mb-8 space-y-0.5">
    <h1 class="text-xl font-semibold tracking-tight">QR Codes</h1>
    <p class="text-sm text-muted-foreground">
        Voici la liste de vos QR Codes.
    </p>
</div>

<x-button class="mb-8" :href="route('qrcodes.create')">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
        <path d="M5 12h14" />
        <path d="M12 5v14" />
    </svg>
    Nouveau
</x-button>

<div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
    @forelse ($qrcodes as $qr)
    <x-card>
        <div class="flex flex-col items-center text-center h-full">
            <div class="relative w-full max-w-[160px] aspect-square mb-4 rounded-md group">
                <img src="{{ asset('storage/qrcodes/'.$qr->uuid.'.svg') }}" alt="QR {{ $qr->title }}" class="w-full h-full object-contain rounded-md" />
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity rounded-md">
                    <x-small-button design="inverse" :href="route('qrcodes.download', [$qr, 'svg'])" title="Télécharger SVG">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                            <path d="M12 15V3" />
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <path d="m7 10 5 5 5-5" />
                        </svg>
                        <span>SVG</span>
                    </x-small-button>
                    <x-small-button design="inverse" :href="route('qrcodes.download', [$qr, 'png'])" title="Télécharger PNG">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                            <path d="M12 15V3" />
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <path d="m7 10 5 5 5-5" />
                        </svg>
                        <span>PNG</span>
                    </x-small-button>
                </div>
            </div>
            <h2 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-1 wrap-anywhere">
                {{ $qr->title }}
            </h2>

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Créé le {{ $qr->created_at->format('d/m/Y') }}<br>
                Modifié le {{ $qr->updated_at->format('d/m/Y') }}<br>
                Scans : {{ $qr->views }}
            </p>

            <div class="flex flex-wrap justify-center gap-2 mt-auto">
                <x-button class="text-xs px-2 py-1 sm:text-sm sm:px-3 sm:py-2" :href="route('qrcodes.show', $qr->uuid)" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <span class="sr-only">Voir</span>
                </x-button>
                <x-button class="text-xs px-2 py-1 sm:text-sm sm:px-3 sm:py-2" :href="route('qrcodes.edit', $qr)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                    </svg>
                    <span class="sr-only">Modifier</span>
                </x-button>
                <form method="POST" action="{{ route('qrcodes.destroy', $qr) }}">
                    @csrf
                    @method('DELETE')
                    <x-form-button class="text-xs px-2 py-1 sm:text-sm sm:px-3 sm:py-2" design="danger" onclick="return confirm('Supprimer ce QR Code ?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                        <span class="sr-only">Supprimer</span>
                    </x-form-button>
                </form>
            </div>
        </div>
    </x-card>
    @empty
    <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-12">
        Aucun QR Code pour le moment.
    </div>
    @endforelse
</div>

@endsection