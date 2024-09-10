<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $genres = [
            'Fiction',
            'Non-fiction',
            'Mystery',
            'Thriller',
            'Science Fiction',
            'Fantasy',
            'Romance',
            'Historical Fiction',
            'Young Adult',
            'Children\'s',
            'Biography',
            'Autobiography',
            'Poetry',
            'Drama',
            'Self-help',
            'Business',
            'Cookbook',
            'Travel',
            'Art',
            'Photography',
            'Music',
            'Philosophy',
            'Religion',
            'History',
            'Science',
            'Technology',
            'Sports',
            'Humor',
            'Graphic Novel',
            'Manga'
        ];

        for ($i = 0; $i < 30; $i++) {
            Book::create([
                'title' => $faker->sentence,
                'author' => $faker->name,
                'isbn' => $faker->isbn13,
                'publication_date' => $faker->dateTimeBetween('2000-01-01', 'now'),
                'genre' => $faker->randomElement($genres),
                'number_of_copies' => $faker->numberBetween(1, 100)
            ]);
        }
    }

}
