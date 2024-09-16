<?php

namespace Database\Seeders\demo;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            'J.K. Rowling',
            'Stephen King',
            'George R.R. Martin',
            'Harper Lee',
            'Jane Austen',
            'J.R.R. Tolkien',
            'Agatha Christie',
            'Paulo Coelho',
            'Margaret Atwood',
            'Neil Gaiman',
            'Yuval Noah Harari',
            'Chimamanda Ngozi Adichie',
            'Kazuo Ishiguro',
            'Toni Morrison',
            'Gabriel García Márquez',
            'Haruki Murakami',
            'Salman Rushdie',
            'Orhan Pamuk',
            'Elena Ferrante',
            'Khaled Hosseini',
            'Colson Whitehead',
            'Ta-Nehisi Coates',
            'Jesmyn Ward',
            'George Saunders',
            'Ottessa Moshfegh',
            'Sally Rooney',
            'Ocean Vuong',
            'Brandon Sanderson',
            'Patrick Rothfuss',
            'N.K. Jemisin',
            'Ursula K. Le Guin',
            'Octavia E. Butler',
            'Liu Cixin',
            'Ken Liu',
            'Ted Chiang',
            'Silvia Moreno-Garcia',
            'Rebecca Roanhorse',
            'Erin Morgenstern',
            'V.E. Schwab',
            'Leigh Bardugo',
            'Sabaa Tahir',
            'Tomi Adeyemi',
            'Angie Thomas',
            'Nicola Yoon',
            'Adam Silvera',
            'Elizabeth Acevedo',
            'Jason Reynolds',
        ];

        foreach ($authors as $authorName) {
            Author::create([
                'name' => $authorName
            ]);
        }
    }
}
