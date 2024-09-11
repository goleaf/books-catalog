<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookGenreRel extends Pivot
{
    protected $table = 'book_genre_rel';

    // You might not need any additional code here since it's a simple pivot table
}
