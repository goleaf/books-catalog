<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title', 'isbn', 'publication_date', 'number_of_copies'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_book_rel');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre_rel');
    }

}
