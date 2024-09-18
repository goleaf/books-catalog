<?php

namespace Database\Seeders\demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Author;
use App\Models\Genre;

class BookSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $authors = Author::all();
        $genres = Genre::all();

        for ($i = 0; $i < 100; $i++) {
            $book = new \App\Models\Book([
                'title' => $faker->unique()->sentence(3),
                'isbn' => $faker->unique()->isbn13,
                'publication_date' => $faker->date(),
                'number_of_copies' => $faker->numberBetween(1, 100),
            ]);
            $book->save();

            $authorCount = $faker->numberBetween(1, 3);
            $genreCount = $faker->numberBetween(1, 5);

            $book->authors()->attach(
                $authors->random($authorCount)->pluck('id')->toArray()
            );

            $book->genres()->attach(
                $genres->random($genreCount)->pluck('id')->toArray()
            );
        }
    }
}
