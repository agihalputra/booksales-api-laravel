<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    private $genres = [
        [
            'name' => 'Fiksi',
            'description' => 'Cerita yang berasal dari imajinasi penulis.'
        ],
        [
            'name' => 'Non-Fiksi',
            'description' => 'Buku yang berdasarkan fakta dan kejadian nyata.'
        ],
        [
            'name' => 'Petualangan',
            'description' => 'Buku yang mengisahkan perjalanan dan eksplorasi.'
        ],
        [
            'name' => 'Motivasi',
            'description' => 'Buku yang memberikan semangat hidup dan inspirasi.'
        ],
        [
            'name' => 'Fantasi',
            'description' => 'Buku yang berisi dunia khayalan dengan unsur magis.'
        ],
    ];

    public function getGenres() {
        return $this->genres;
    }
}
