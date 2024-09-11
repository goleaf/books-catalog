<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class Genres extends Component
{
    public $genres = [];
    public $genre;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    protected $listeners = ['genreDeleted' => 'loadGenres'];

    protected $rules = [
        'genre.name' => 'required|string|max:255|unique:genres,name',
    ];

    protected $messages = [
        'genre.name.required' => 'The name field is required.',
        'genre.name.string' => 'The name must be a string.',
        'genre.name.max' => 'The name may not be greater than 255 characters.',
        'genre.name.unique' => 'This genre already exists.',
    ];

    /**
     * Mount the component and load the initial list of genres
     */
    public function mount(): void
    {
        $this->loadGenres();
    }

    /**
     * Load the genres from the database
     */
    public function loadGenres(): void
    {
        $this->genres = Genre::all();
    }

    /**
     * Show the form for creating a new genre
     */
    public function create(): void
    {
        $this->reset(['genre', 'editMode']);
        $this->showForm = true;
    }

    /**
     * Store a new genre in the database
     */
    public function store(): void
    {
        $this->validate();

        try {
            Genre::create($this->genre);
            $this->successMessage = 'Genre added successfully!';
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->resetFormAndLoadGenres();
        }
    }

    /**
     * Show the form for editing an existing genre
     *
     * @param Genre $genre The genre to edit
     */
    public function edit(Genre $genre): void
    {
        $this->genre = $genre->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    /**
     * Update an existing genre in the database
     */
    public function update(): void
    {
        $this->validate();

        try {
            $genre = Genre::findOrFail($this->genre['id']);
            $genre->update($this->genre);
            $this->successMessage = 'Genre updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->resetFormAndLoadGenres();
        }
    }

    /**
     * Delete a genre from the database
     *
     * @param Genre $genre The genre to delete
     */
    public function delete(Genre $genre): void
    {
        try {
            if ($genre->books()->count() > 0) {
                $this->errorMessages[] = 'Cannot delete genre with associated books.';
            } else {
                $genre->delete();
                $this->successMessage = 'Genre deleted successfully!';
            }
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->loadGenres();
        }
    }

    /**
     * Handle errors that occur during genre operations
     *
     * @param string $action The action that triggered the error (e.g., 'adding', 'updating', 'deleting')
     * @param \Exception $exception The exception object
     */
    private function handleError($action, $exception): void
    {
        $this->errorMessages[] = 'Error ' . $action . ' genre.';
        Log::error('Error ' . $action . ' genre:', ['exception' => $exception]);
    }

    /**
     * Reset the form, hide it and reload genres
     */
    private function resetFormAndLoadGenres(): void
    {
        $this->reset(['genre', 'editMode', 'errorMessages']);
        $this->showForm = false;
        $this->loadGenres();
    }

    public function render()
    {
        return view('livewire.genres.index');
    }
}
