<?php

namespace Database\Seeders\demo;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    const GENRES = [
        'Absurdist Fiction', 'Action', 'Adventure Fiction', 'Adventure Romance', 'Adventure',
        'Afrofuturism', 'Alien Invasion', 'Allegory', 'Alternate History', 'Anime',
        'Apocalyptic Fiction', 'Art', 'Bildungsroman', 'Biographical Fiction', 'Biography',
        'Business', 'Chick Lit', 'Children\'s Literature', 'Children\'s', 'Christian Fiction',
        'Classic', 'Cli-Fi (Climate Fiction)', 'Comedy', 'Coming-of-Age', 'Contemporary Fiction',
        'Contemporary Romance', 'Contemporary', 'Cookbook', 'Cozy Mystery', 'Crime',
        'Cyberpunk', 'Dark Fantasy', 'Detective Fiction', 'Detective Noir', 'Domestic Fiction',
        'Drama', 'Dystopian', 'Eco-Fiction', 'Economics', 'Epic Fantasy',
        'Erotica', 'Espionage', 'Experimental Fiction', 'Fairy Tale Retelling', 'Family Saga',
        'Fantasy', 'Feminist Fiction', 'Feminist', 'Folklore', 'GameLit',
        'Ghost Stories', 'Gothic Fiction', 'Graphic Novel', 'Hard Science Fiction', 'Hard-Boiled Mystery',
        'Hardboiled', 'Heroic Fantasy', 'High Fantasy', 'Historical Fiction', 'Historical Romance',
        'History', 'Horror', 'Humor', 'Inspirational Fiction', 'LGBTQ+',
        'Legal Drama', 'Legal Thriller', 'LitRPG', 'Literary Fiction', 'Low Fantasy',
        'Magical Realism', 'Manga', 'Medical Thriller', 'Memoir', 'Metafiction',
        'Middle Grade', 'Military Fiction', 'Mystery', 'Mythology', 'Noir',
        'Paranormal Romance', 'Paranormal', 'Philosophical Fiction', 'Philosophy', 'Photography',
        'Poetry', 'Political Fiction', 'Political Thriller', 'Post-Apocalyptic Fiction', 'Post-Apocalyptic',
        'Postmodern Fiction', 'Psychological Fiction', 'Psychological Thriller', 'Quest Fiction', 'Regency Romance',
        'Religion', 'Religious Fiction', 'Romance', 'Satire', 'Science Fiction',
        'Science', 'Self-help', 'Soft Science Fiction', 'Space Opera', 'Sports Fiction',
        'Spy Fiction', 'Steampunk', 'Superhero Fiction', 'Supernatural Fiction', 'Surrealism',
        'Suspense', 'Sword and Sorcery', 'Techno-Thriller', 'Technology', 'Thriller',
        'Time Travel', 'Tragedy', 'Transgressive Fiction', 'Travel', 'Urban Fantasy',
        'Vampires', 'War Fiction', 'Weird Fiction', 'Werewolves', 'Western',
        'Young Adult (YA)', 'Young Adult', 'Zombies',
    ];

    public function run()
    {
        foreach (self::GENRES as $genreName) {
            Genre::create(['name' => $genreName]);
        }
    }
}
