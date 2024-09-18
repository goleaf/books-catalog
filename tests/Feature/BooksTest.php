<?php

namespace Tests\Feature;

use App\Http\Livewire\Books;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory as Faker;

class BooksTest extends TestCase
{
    use DatabaseTransactions;

    protected $author;
    protected $genre;

    public function setUp(): void
    {
        parent::setUp();
        $this->author = Author::inRandomOrder()->first();
        $this->genre = Genre::inRandomOrder()->first();
    }

    /** @test */
    public function it_can_render_books_component()
    {
        Livewire::test(Books::class)
            ->assertViewIs('livewire.books.index');
    }


    /** @test */
    public function it_can_load_books()
    {
        Livewire::test(Books::class)
            ->call('loadBooks')
            ->assertEmitted('booksLoaded');
    }
    /** @test */
    public function it_can_reset_filters()
    {
        Livewire::test(Books::class)
            ->set('searchTitle', 'Test')
            ->set('filterAuthor', 1)
            ->set('searchIsbn', '1234')
            ->set('filterGenre', 1)
            ->set('filterCopiesFrom', 5)
            ->set('filterCopiesTo', 10)
            ->set('filterPublicationDateFrom', '2022-01-01')
            ->set('filterPublicationDateTo', '2022-12-31')
            ->call('resetFilters')
            ->assertSet('searchTitle', '')
            ->assertSet('filterAuthor', '')
            ->assertSet('searchIsbn', '')
            ->assertSet('filterGenre', '')
            ->assertSet('filterCopiesFrom', null)
            ->assertSet('filterCopiesTo', null)
            ->assertSet('filterPublicationDateFrom', null)
            ->assertSet('filterPublicationDateTo', null)
            ->assertEmitted('booksLoaded');
    }

    /** @test */
    public function it_can_sort_books_ascending()
    {
        Book::factory()->count(3)->create();

        Livewire::test(Books::class)
            ->set('sortBy', 'title')
            ->set('sortDirection', 'asc')
            ->call('loadBooks')
            ->assertSet('books', function ($loadedBooks) {
                return $loadedBooks->pluck('title')->toArray() === $loadedBooks->sortBy('title')->pluck('title')->toArray();
            })
            ->assertEmitted('booksLoaded');
    }

    /** @test */
    public function it_can_sort_books_descending()
    {
        Book::factory()->count(3)->create();

        Livewire::test(Books::class)
            ->set('sortBy', 'title')
            ->set('sortDirection', 'desc')
            ->call('loadBooks')
            ->assertSet('books', function ($loadedBooks) {
                return $loadedBooks->pluck('title')->toArray() === $loadedBooks->sortByDesc('title')->pluck('title')->toArray();
            })
            ->assertEmitted('booksLoaded');
    }

    /** @test */
    public function it_can_filter_books()
    {
        Book::factory()->count(3)->create();
        $filteredBook = Book::factory()->create(['title' => 'Unique Test Book']);

        Livewire::test(Books::class)
            ->set('searchTitle', 'Unique Test')
            ->call('loadBooks')
            ->assertSet('books', function ($loadedBooks) use ($filteredBook) {
                return $loadedBooks->count() === 1 && $loadedBooks->first()->id === $filteredBook->id;
            });
    }

    /** @test */
    public function it_can_create_a_new_book()
    {
        $faker = Faker::create();

        $title = $faker->sentence(3);
        $isbn = $faker->isbn13();
        $publicationDate = $faker->date();
        $numberOfCopies = $faker->numberBetween(1, 100);

        Livewire::test(Books::class)
            ->set('book.title', $title)
            ->set('book.isbn', $isbn)
            ->set('book.publication_date', $publicationDate)
            ->set('book.number_of_copies', $numberOfCopies)
            ->set('selectedAuthors', [$this->author->id])
            ->set('selectedGenres', [$this->genre->id])
            ->call('store')
            ->assertHasNoErrors()
            ->assertEmitted('bookAdded');

        $this->assertDatabaseHas('books', [
            'title' => $title,
            'isbn' => $isbn,
            'publication_date' => $publicationDate,
            'number_of_copies' => $numberOfCopies
        ]);

        $this->assertDatabaseHas('rel_author_book', [
            'author_id' => $this->author->id
        ]);

        $this->assertDatabaseHas('rel_book_genre', [
            'genre_id' => $this->genre->id
        ]);
    }

    /** @test */
    public function it_can_update_an_existing_book(): void
    {
        $book = Book::inRandomOrder()->first();

        $originalTitle = $book->title;
        $originalIsbn = $book->isbn;
        $originalPublicationDate = $book->publication_date;
        $originalNumberOfCopies = $book->number_of_copies;

        $faker = Faker::create();

        $newTitle = $faker->sentence(3);
        $newIsbn = $faker->isbn13();
        $newPublicationDate = $faker->date();
        $newNumberOfCopies = $faker->numberBetween(1, 100);

        Livewire::test(Books::class)
            ->call('edit', $book)
            ->set('book.title', $newTitle)
            ->set('book.isbn', $newIsbn)
            ->set('book.publication_date', $newPublicationDate)
            ->set('book.number_of_copies', $newNumberOfCopies)
            ->set('selectedAuthors', [$this->author->id])
            ->set('selectedGenres', [$this->genre->id])
            ->call('update')
            ->assertHasNoErrors()
            ->assertEmitted('bookUpdated');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $newTitle,
            'isbn' => $newIsbn,
            'publication_date' => $newPublicationDate,
            'number_of_copies' => $newNumberOfCopies
        ]);

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
            'title' => $originalTitle,
            'isbn' => $originalIsbn,
            'publication_date' => $originalPublicationDate,
            'number_of_copies' => $originalNumberOfCopies
        ]);

        $this->assertDatabaseHas('rel_author_book', [
            'book_id' => $book->id,
            'author_id' => $this->author->id
        ]);

        $this->assertDatabaseHas('rel_book_genre', [
            'book_id' => $book->id,
            'genre_id' => $this->genre->id
        ]);
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        Livewire::test(Books::class)
            ->call('delete', $book->id)
            ->assertEmitted('bookDeleted');

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

}
