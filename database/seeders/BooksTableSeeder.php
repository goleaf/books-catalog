<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Http;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $authors = Author::all();
        $genres = Genre::all();

        // Use the full list of genres
        $genresForQuery = [
            'Adventure',
            'Fantasy',
            'Science Fiction',
            'Historical Fiction',
            'Mystery',
            'Thriller',
            'Horror',
            'Romance',
            'Dystopian',
            'Contemporary Fiction',
            'Crime',
            'Detective Fiction',
            'Western',
            'Bildungsroman',
            'Gothic Fiction',
            'Magical Realism',
            'Cyberpunk',
            'Steampunk',
            'Space Opera',
            'Time Travel',
            'Paranormal',
            'Urban Fantasy',
            'Alternate History',
            'High Fantasy',
            'Low Fantasy',
            'Dark Fantasy',
            'Sword and Sorcery',
            'Apocalyptic Fiction',
            'Post-Apocalyptic Fiction',
            'Legal Thriller',
            'Psychological Thriller',
            'Political Thriller',
            'Spy Fiction',
            'Military Fiction',
            'War Fiction',
            'Suspense',
            'Epic Fantasy',
            'Fairy Tale Retelling',
            'Alien Invasion',
            'Hard Science Fiction',
            'Soft Science Fiction',
            'Superhero Fiction',
            'Supernatural Fiction',
            'Vampires',
            'Werewolves',
            'Zombies',
            'Ghost Stories',
            'Mythology',
            'Folklore',
            'Young Adult (YA)',
            'Middle Grade',
            'Children\'s Literature',
            'Literary Fiction',
            'Satire',
            'Comedy',
            'Drama',
            'Tragedy',
            'Historical Romance',
            'Regency Romance',
            'Contemporary Romance',
            'Paranormal Romance',
            'Chick Lit',
            'Family Saga',
            'Coming-of-Age',
            'Adventure Romance',
            'Erotica',
            'Biographical Fiction',
            'Religious Fiction',
            'Christian Fiction',
            'Inspirational Fiction',
            'Political Fiction',
            'Philosophical Fiction',
            'Noir',
            'Action',
            'Medical Thriller',
            'Legal Drama',
            'Cozy Mystery',
            'Hard-Boiled Mystery',
            'Detective Noir',
            'Espionage',
            'Techno-Thriller',
            'Sports Fiction',
            'GameLit',
            'LitRPG',
            'Postmodern Fiction',
            'Absurdist Fiction',
            'Metafiction',
            'Experimental Fiction',
            'Surrealism',
            'Transgressive Fiction',
            'Domestic Fiction',
            'Feminist Fiction',
            'Psychological Fiction',
            'Allegory',
            'Eco-Fiction',
            'Cli-Fi (Climate Fiction)',
            'Weird Fiction',
            'Adventure Fiction',
            'Quest Fiction',
            'Heroic Fantasy',
        ];

        for ($i = 0; $i < 100; $i++) {
            $randomGenre = $genresForQuery[array_rand($genresForQuery)];

            $response = Http::get('https://www.googleapis.com/books/v1/volumes?q=subject:' . urlencode($randomGenre) . '&maxResults=1');

            if ($response->successful()) {
                $bookData = $response->json()['items'][0]['volumeInfo'];
                $title = $bookData['title'];

                Book::create([
                    'title' => $title,
                    'author_id' => $authors->random()->id,
                    'isbn' => $faker->isbn13,
                    'publication_date' => $faker->date(),
                    'genre_id' => $genres->random()->id,
                    'number_of_copies' => $faker->numberBetween(1, 100),
                ]);
            } else {
                echo "Error fetching book data from Google Books API. Status code: " . $response->status() . "\n";
            }
        }
    }
}
