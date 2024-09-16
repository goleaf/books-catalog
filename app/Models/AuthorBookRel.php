<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot; // Extend the Pivot class

class AuthorBookRel extends Pivot
{
    protected $table = 'author_book_rel';

    protected $fillable = [
        'author_id', 'book_id'
    ];
}


