<?php

namespace Database\Seeders\demo;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all authors and genres from the database
        $authors = Author::all();
        $genres = Genre::all();

        for ($i = 0; $i < 100; $i++) {
            $book = Book::create([
                'title' => $faker->sentence,
                'isbn' => $faker->isbn13,
                'publication_date' => $faker->date(),
                'number_of_copies' => $faker->numberBetween(1, 100),
            ]);

            // Attach random authors (between 1 and 3)
            $randomAuthors = $authors->random($faker->numberBetween(1, 3));
            $book->authors()->attach($randomAuthors);

            // Attach random genres (between 1 and 3)
            $randomGenres = $genres->random($faker->numberBetween(1, 3));
            $book->genres()->attach($randomGenres);
        }
    }
}
