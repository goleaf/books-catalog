<?php

namespace Database\Seeders;

use Database\Seeders\demo\AuthorSeeder;
use Database\Seeders\demo\BookSeeder;
use Database\Seeders\demo\GenreSeeder;
use Database\Seeders\demo\UserSeeder;
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
            UserSeeder::class,
            AuthorSeeder::class,
            GenreSeeder::class,
            BookSeeder::class,
        ]);
    }
}
