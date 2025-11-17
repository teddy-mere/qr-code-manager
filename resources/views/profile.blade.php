@extends('layouts.app')
@section('title', 'Profil')

@section('content')
<div class="mb-8 space-y-0.5">
    <h1 class="text-xl font-semibold tracking-tight">Profil</h1>
    <p class="text-sm text-muted-foreground">Gérez votre profil</p>
</div>
<div class="flex flex-col lg:flex-row lg:space-x-12">
    <aside class="w-full max-w-xl lg:w-48">
        <nav class="flex flex-col space-y-1 space-x-0">
            <x-subnav-item href="#" data-tab="profile-information" class="tab-link bg-muted">
                Profil
            </x-subnav-item>
            <x-subnav-item href="#" data-tab="password" class="tab-link">
                Mot de passe
            </x-nav-item>
        </nav>
    </aside>
    <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
            <div class="space-y-6 animate-in fade-in tab-content" id="profile-information">
                <header>
                    <h3 class="mb-0.5 text-base font-medium">Informations du profil</h3>
                    <p class="text-sm text-muted-foreground">Changez votre nom et votre adresse email</p>
                </header>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf @method('PATCH')

                    <div class="grid gap-2">
                        <x-form-label for="name" value="Nom" />
                        <x-form-input id="name" required tabindex="1" placeholder="Votre nom" type="text" name="name" :value="auth()->user()->name" />
                    </div>

                    <div class="grid gap-2">
                        <x-form-label for="email" value="Adresse e-mail" />
                        <x-form-input id="email" required tabindex="1" placeholder="Votre adresse e-mail" type="email" name="email" :value="auth()->user()->email" />
                    </div>

                    <x-form-button>
                        Sauvegarder
                    </x-form-button>
                </form>
            </div>
            <div class="space-y-6 animate-in fade-in hidden tab-content" id="password">
                <header>
                    <h3 class="mb-0.5 text-base font-medium">Changer le mot de passe</h3>
                    <p class="text-sm text-muted-foreground">Assurez-vous que votre compte est sécurisé avec un mot de passe fort.</p>
                </header>
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid gap-2">
                        <x-form-label for="current_password" value="Mot de passe actuel" />
                        <x-form-input id="current_password" required  placeholder="Votre mot de passe actuel" type="password" name="current_password" />
                    </div>

                    <div class="grid gap-2">
                        <x-form-label for="password" value="Nouveau mot de passe" />
                        <x-form-input id="password" required  placeholder="Votre nouveau mot de passe" type="password" name="password" />
                    </div>

                    <div class="grid gap-2">
                        <x-form-label for="password_confirmation" value="Confirmer le nouveau mot de passe" />
                        <x-form-input id="password_confirmation" required  placeholder="Confirmez votre nouveau mot de passe" type="password" name="password_confirmation" />
                    </div>

                    <x-form-button>
                        Sauvegarder
                    </x-form-button>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection