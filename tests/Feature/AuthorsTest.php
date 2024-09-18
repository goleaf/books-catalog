<?php

namespace Tests\Feature;

use App\Http\Livewire\Authors;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory as Faker;

class AuthorsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_render_authors_component()
    {
        Livewire::test(Authors::class)
            ->assertViewIs('livewire.authors.index');
    }

    /** @test */
    public function it_can_load_authors()
    {
        Author::factory()->count(5)->create();

        Livewire::test(Authors::class)
            ->call('loadAuthors')
            ->assertEmitted('authorsLoaded');
    }

    /** @test */
    public function it_can_reset_filters()
    {
        Livewire::test(Authors::class)
            ->set('searchName', 'Test')
            ->set('filterBooksFrom', 1)
            ->set('filterBooksTo', 10)
            ->call('resetFilters')
            ->assertSet('searchName', '')
            ->assertSet('filterBooksFrom', null)
            ->assertSet('filterBooksTo', null)
            ->assertEmitted('authorsLoaded');
    }

    /** @test */
    public function it_can_sort_authors_ascending()
    {
        Author::factory()->count(3)->create();

        Livewire::test(Authors::class)
            ->set('sortBy', 'name')
            ->set('sortDirection', 'asc')
            ->call('loadAuthors')
            ->assertSet('authors', function ($loadedAuthors) {
                return $loadedAuthors->pluck('name')->toArray() === $loadedAuthors->sortBy('name')->pluck('name')->toArray();
            })
            ->assertEmitted('authorsLoaded');
    }

    /** @test */
    public function it_can_sort_authors_descending()
    {
        Author::factory()->count(3)->create();

        Livewire::test(Authors::class)
            ->set('sortBy', 'name')
            ->set('sortDirection', 'desc')
            ->call('loadAuthors')
            ->assertSet('authors', function ($loadedAuthors) {
                return $loadedAuthors->pluck('name')->toArray() === $loadedAuthors->sortByDesc('name')->pluck('name')->toArray();
            })
            ->assertEmitted('authorsLoaded');
    }

    /** @test */
    public function it_can_filter_authors()
    {
        Author::factory()->count(3)->create();
        $filteredAuthor = Author::factory()->create(['name' => 'Unique Test Author']);

        Livewire::test(Authors::class)
            ->set('searchName', 'Unique Test')
            ->call('loadAuthors')
            ->assertSet('authors', function ($loadedAuthors) use ($filteredAuthor) {
                return $loadedAuthors->count() === 1 && $loadedAuthors->first()->id === $filteredAuthor->id;
            });
    }

    /** @test */
    public function it_can_create_a_new_author()
    {
        $faker = Faker::create();
        $name = $faker->name;

        Livewire::test(Authors::class)
            ->set('author.name', $name)
            ->call('store')
            ->assertHasNoErrors()
            ->assertEmitted('authorAdded');

        $this->assertDatabaseHas('authors', [
            'name' => $name,
        ]);
    }

    /** @test */
    public function it_can_update_an_existing_author()
    {
        $author = Author::factory()->create();
        $faker = Faker::create();
        $newName = $faker->name;

        Livewire::test(Authors::class)
            ->call('edit', $author)
            ->set('author.name', $newName)
            ->call('update')
            ->assertHasNoErrors()
            ->assertEmitted('authorUpdated');

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => $newName,
        ]);
    }

    /** @test */
    public function it_can_delete_an_author()
    {
        $author = Author::factory()->create();

        Livewire::test(Authors::class)
            ->call('delete', $author->id)
            ->assertEmitted('authorDeleted');

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
