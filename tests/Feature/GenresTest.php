<?php

namespace Tests\Feature;

use App\Http\Livewire\Genres;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory as Faker;

class GenresTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_render_genres_component()
    {
        Livewire::test(Genres::class)
            ->assertViewIs('livewire.genres.index');
    }

    /** @test */
    public function it_can_load_genres()
    {
        $faker = Faker::create();

        // Create test data with random unique names
        $genre1 = Genre::factory()->create(['name' => $faker->unique()->words(3, true)]);
        $genre2 = Genre::factory()->create(['name' => $faker->unique()->words(3, true)]);
        $genre3 = Genre::factory()->create(['name' => $faker->unique()->words(3, true)]);

        // Create some books and relate them to genres
        $books1 = Book::factory()->count(3)->create();
        $books2 = Book::factory()->count(2)->create();
        $books3 = Book::factory()->count(1)->create();

        $genre1->books()->attach($books1->pluck('id'));
        $genre2->books()->attach($books2->pluck('id'));
        $genre3->books()->attach($books3->pluck('id'));

        Livewire::test(Genres::class)
            ->set('searchName', substr($genre2->name, 0, 3))
            ->set('filterBooksFrom', 2)
            ->set('filterBooksTo', 3)
            ->set('sortBy', 'name')
            ->set('sortDirection', 'asc')
            ->call('loadGenres')
            ->assertSet('genres', function ($genres) use ($genre2) {
                return $genres->count() === 1 &&
                       $genres->first()->name === $genre2->name &&
                       $genres->first()->books_count === 2;
            })
            ->assertEmitted('genresLoaded');
    }


    /** @test */
    public function it_can_reset_filters()
    {
        Livewire::test(Genres::class)
            ->set('searchName', 'Test')
            ->set('filterBooksFrom', 1)
            ->set('filterBooksTo', 10)
            ->call('resetFilters')
            ->assertSet('searchName', '')
            ->assertSet('filterBooksFrom', null)
            ->assertSet('filterBooksTo', null)
            ->assertEmitted('genresLoaded');
    }

    /** @test */
    public function it_can_create_a_new_genre()
    {
        $faker = Faker::create();
        $name = $faker->unique()->word;

        Livewire::test(Genres::class)
            ->set('genre.name', $name)
            ->call('store')
            ->assertHasNoErrors()
            ->assertEmitted('genreAdded');

        $this->assertDatabaseHas('genres', [
            'name' => $name,
        ]);
    }

    /** @test */
    public function it_can_update_an_existing_genre()
    {
        $genre = Genre::factory()->create();
        $faker = Faker::create();
        $newName = $faker->unique()->word;

        Livewire::test(Genres::class)
            ->call('edit', $genre)
            ->set('genre.name', $newName)
            ->call('update')
            ->assertHasNoErrors()
            ->assertEmitted('genreUpdated');

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => $newName,
        ]);
    }

    /** @test */
    public function it_can_delete_a_genre()
    {
        $genre = Genre::factory()->create();

        Livewire::test(Genres::class)
            ->call('delete', $genre)
            ->assertEmitted('genreDeleted');

        $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
    }
}
