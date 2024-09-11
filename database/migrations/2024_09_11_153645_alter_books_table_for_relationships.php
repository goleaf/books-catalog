<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('author');
            $table->dropColumn('genre');

            $table->unsignedBigInteger('author_id')->nullable()->after('title');
            $table->unsignedBigInteger('genre_id')->nullable()->after('publication_date');

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['genre_id']);
            $table->dropColumn('author_id');
            $table->dropColumn('genre_id');

            $table->string('author')->after('title');
            $table->string('genre')->after('publication_date');
        });
    }
};
