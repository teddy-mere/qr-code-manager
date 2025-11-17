<?php

namespace Database\Seeders;

use App\Models\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use tbQuar\Facades\Quar;
use Faker\Factory as Faker;

class QrCodeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $fields = [];
            $nombreChamps = rand(2, 5);
            for ($j = 0; $j < $nombreChamps; $j++) {
                $fields[] = [
                    'label' => $faker->sentence(),
                    'value' => $faker->paragraph(),
                ];
            }

            $createdAt = $faker->dateTimeBetween('-1 years', 'now');
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');

            $qrcode = QrCode::create([
                'uuid' => (string) Str::uuid(),
                'title' => $faker->sentence(2),
                'fields' => $fields,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'views' => rand(0, 1000),
            ]);

            $path = "qrcodes/{$qrcode->uuid}.svg";

            if (Storage::disk('public')->exists($path)) {
                return;
            }

            $url = route('qrcodes.show', $qrcode->uuid);

            $qr = Quar::size(1024)->generate($url);

            Storage::disk('public')->put($path, $qr);
        }
    }
}
