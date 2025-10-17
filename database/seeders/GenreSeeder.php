<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        Genre::create([
            'name' => 'Action',
            'description' => 'Genre yang menekankan pada adegan aksi',
        ]);

        Genre::create([
            'name' => 'Romance',
            'description' => 'Genre yang menekankan pada hubungan romantis',
        ]);

        Genre::create([
            'name' => 'Fantasi',
            'description' => 'Genre yang menekankan pada imajinasi dan dunia khayal',
        ]);
    }
}
