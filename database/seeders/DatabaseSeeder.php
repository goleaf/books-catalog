<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call your individual seeders here
        $this->call([
            BooksTableSeeder::class,
            UserSeeder::class,
            AuthorSeeder::class,
            GenreSeeder::class,
        ]);
    }
}
