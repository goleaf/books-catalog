<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('author_book_rel', 'rel_author_book');
        Schema::rename('book_genre_rel', 'rel_book_genre');
    }

};
