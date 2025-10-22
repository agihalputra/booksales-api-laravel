<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'cover_photo',
        'genre_id',
        'author_id'
    ];

    // Relasi ke Author
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    // Relasi ke Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
