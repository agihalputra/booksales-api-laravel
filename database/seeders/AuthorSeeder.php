<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create([
            'name' => 'Tere Liye',
            'photo' => 'tere_liye.jpg',
            'bio' => 'Penulis terkenal Indonesia dengan banyak karya inspiratif.',
        ]);

        Author::create([
            'name' => 'Mark Manson',
            'photo' => 'mark_manson.jpg',
            'bio' => 'Penulis buku pengembangan diri asal Amerika.',
        ]);

        Author::create([
            'name' => 'Masashi Kishimoto',
            'photo' => 'kishimoto.jpg',
            'bio' => 'Mangaka Jepang yang terkenal dengan karya Naruto.',
        ]);

        Author::create([
            'name' => 'Andrea Hirata',
            'photo' => 'andrea_hirata.jpg',
            'bio' => 'Penulis novel Laskar Pelangi.',
        ]);

        Author::create([
            'name' => 'JK Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'Penulis seri terkenal Harry Potter.',
        ]);
    }
}
