@extends('layouts.guest')
@section('title', 'Connexion')

@section('content')
<div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
    <div class="w-full max-w-sm">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4">
                <div class="flex flex-col items-center gap-2 font-medium">
                    <div class="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                        <svg class="size-9 text-[var(--foreground)] dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 12v4a1 1 0 0 1-1 1h-4" />
                            <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                            <path d="M17 8V7" />
                            <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                            <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                            <path d="M7 17h.01" />
                            <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                            <rect x="7" y="7" width="5" height="5" rx="1" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-2 text-center">
                    <h1 class="text-xl font-medium">Connectez-vous à votre compte</h1>
                    <p class="text-center text-sm text-muted-foreground">Saisissez votre adresse e-mail et votre mot de passe pour vous connecter.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <x-form-label for="email" value="Adresse e-mail" />
                        <x-form-input id="email" required tabindex="1" autocomplete="email" placeholder="adresse@email.fr" type="email" name="email" :value="old('email')" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <x-form-label for="password" value="Mot de passe" />
                            {{-- <a class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500 ml-auto text-sm" tabindex="5" href="#">Mot de passe oublié ?</a> --}}
                        </div>
                        <x-form-input id="password" required tabindex="2" autocomplete="current-password" placeholder="Mot de passe" type="password" name="password" />
                    </div>

                    <div class="flex items-center space-x-3">
                        <x-form-checkbox id="remember_me" name="remember" type="checkbox" tabindex="3" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute hidden peer-checked:block peer-checked:text-primary-foreground size-4">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        <x-form-label for="remember_me" value="Se souvenir de moi" />
                    </div>

                    <x-form-button tabindex="4" class="mt-4 w-full">
                        Se connecter
                    </x-form-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection