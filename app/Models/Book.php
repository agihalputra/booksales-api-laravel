<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    private $books = [
        [
            'title' =>'pulang',
            'description' =>'Petualang seorang pemuda yang kembali ke desa kelahiranya',
            'price' => 40000,
            'stock' =>12,
            'Cover_photo' => 'pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1
        ],
        [
            'title' =>'sebuah seni untuk bersikap bodo amat',
            'description' =>'buku yang membahas tentang kehidupan dan filosofi hidup',
            'price' => 25000,
            'stock' =>18,
            'Cover_photo' => 'sebuah_seni.jpg',
            'genre_id' => 2,
            'author_id' => 2
        ],
        [
            'title' =>'Naruto',
            'description' =>'Buku yang membahas tentang jalan ninja',
            'price' => 30000,
            'stock' =>35,
            'Cover_photo' => 'Naruto.jpg',
            'genre_id' => 3,
            'author_id' => 3
        ],
    ];
    public function getBooks() {
        return $this->books;
    }
}
