<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@demo.fr',
            'password' => Hash::make('demodemo'),
        ]);

        Storage::disk('public')->deleteDirectory('qrcodes');
        Storage::disk('public')->makeDirectory('qrcodes');

        $this->call([
            QrCodeSeeder::class,
        ]);
    }
}
