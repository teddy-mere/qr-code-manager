<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class SetupInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configuration du projet (environnement, compte administrateur).';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('Configuration de l’environnement...');
        $defaultUrl = URL::to('/');
        $url = $this->ask("APP_URL", $defaultUrl);
        $this->setEnv('APP_URL', $url);
        $this->setEnv('APP_ENV', 'production');
        $this->setEnv('APP_DEBUG', 'false');
        $this->info('Environnement configuré !');

        $this->info('Création du compte administrateur...');
        $name = $this->ask('Nom');
        $email = $this->ask('Email');
        $password = $this->secret('Mot de passe');
        User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($password)]
        );
        $this->info('Compte administrateur créé !');

        $this->info('Installation terminée !');
    }

    protected function setEnv($key, $value): void
    {
        $path = base_path('.env');
        if (!file_exists($path)) return;

        file_put_contents(
            $path,
            preg_replace("/^{$key}=.*/m", "{$key}={$value}", file_get_contents($path))
        );
    }
}
