@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<div class="mb-8 space-y-0.5">
    <h1 class="text-xl font-semibold tracking-tight">Bienvenue, {{ auth()->user()->getFirstName() }} 👋</h1>
    <p class="text-sm text-muted-foreground">
        Voici un aperçu de l’activité de vos QR Codes.
    </p>
</div>
<div class="space-y-8">
    <div class="grid gap-6 md:grid-cols-3">
        <x-card>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">QR Codes créés</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400 dark:text-gray-600">
                    <rect width="5" height="5" x="3" y="3" rx="1" />
                    <rect width="5" height="5" x="16" y="3" rx="1" />
                    <rect width="5" height="5" x="3" y="16" rx="1" />
                    <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                    <path d="M21 21v.01" />
                    <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                    <path d="M3 12h.01" />
                    <path d="M12 3h.01" />
                    <path d="M12 16v.01" />
                    <path d="M16 12h1" />
                    <path d="M21 12v.01" />
                    <path d="M12 21v-1" />
                </svg>
            </div>
            <p class="mt-3 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalQrCodes }}</p>
        </x-card>

        <x-card>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Scans totaux</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-600">
                    <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
                </svg>
            </div>
            <p class="mt-3 text-3xl font-semibold text-gray-900 dark:text-white">{{ $totalScans }}</p>
        </x-card>
    </div>

    <div class="flex justify-end">
        <x-button type="bordered" :href="route('qrcodes.create')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Créer un QR Code
        </x-button>
    </div>

    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">Derniers QR Codes</h2>
            <a href="{{ route('qrcodes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Voir tout</a>
        </div>
        @forelse($lastQrCodes as $qrCode)
        <div class="flex items-start justify-between gap-4 p-3 rounded-lg hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition mb-2">

            {{-- Lien principal --}}
            <a href="{{ route('qrcodes.show', $qrCode->uuid) }}" target="_blank" class="flex items-center gap-4 flex-1" title="Afficher le QR Code">
                <div class="w-12 h-12 flex-shrink-0 rounded-md bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/qrcodes/'.$qrCode->uuid.'.svg') }}" alt="QR {{ $qrCode->title }}" class="w-full h-full object-contain">
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-900 dark:text-white wrap-anywhere">
                        {{ $qrCode->title }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Créé le {{ $qrCode->created_at->format('d/m/Y') }} | Scans : {{ $qrCode->views }}
                    </p>
                </div>
            </a>
            <div class="flex gap-1">
                <x-small-button design="inverse-bordered" :href="route('qrcodes.download', [$qrCode, 'svg'])">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M12 15V3" />
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path d="m7 10 5 5 5-5" />
                    </svg>
                    SVG
                </x-small-button>
                <x-small-button design="inverse-bordered" :href="route('qrcodes.download', [$qrCode, 'png'])">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M12 15V3" />
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path d="m7 10 5 5 5-5" />
                    </svg>
                    PNG
                </x-small-button>
                <x-small-button :href="route('qrcodes.edit', $qrCode->uuid)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                    </svg>
                    Modifier
                </x-small-button>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
            Aucun QR Code pour le moment.
        </div>
        @endforelse
    </x-card>

</div>
@endsection