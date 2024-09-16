<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookGenreRel extends Pivot
{
    protected $table = 'book_genre_rel';

    protected $fillable = [
        'book_id', 'genre_id'
    ];

}
