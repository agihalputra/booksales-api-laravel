<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    private $authors = [
        [
            'name' => 'Tere Liye',
            'photo' => 'tere_liye.jpg',
            'bio' => 'Penulis terkenal Indonesia dengan banyak karya inspiratif.'
        ],
        [
            'name' => 'Mark Manson',
            'photo' => 'mark_manson.jpg',
            'bio' => 'Penulis buku pengembangan diri asal Amerika.'
        ],
        [
            'name' => 'Masashi Kishimoto',
            'photo' => 'kishimoto.jpg',
            'bio' => 'Mangaka Jepang yang terkenal dengan karya Naruto.'
        ],
        [
            'name' => 'Andrea Hirata',
            'photo' => 'andrea_hirata.jpg',
            'bio' => 'Penulis novel Laskar Pelangi.'
        ],
        [
            'name' => 'JK Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'Penulis seri terkenal Harry Potter.'
        ],
    ];

    public function getAuthors() {
        return $this->authors;
    }
}
