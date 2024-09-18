<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class Genres extends Component
{
    /**
     * List of genres.
     *
     * @var array
     */
    public $genres = [];

    /**
     * Current genre being edited or created.
     *
     * @var array|null
     */
    public $genre;

    /**
     * Flag to show/hide the genre form.
     *
     * @var bool
     */
    public $showForm = false;

    /**
     * Flag to indicate if we're in edit mode.
     *
     * @var bool
     */
    public $editMode = false;

    /**
     * Success message to display.
     *
     * @var string
     */
    public $successMessage = '';

    /**
     * Error messages to display.
     *
     * @var array
     */
    public $errorMessages = [];

    /**
     * Search term for genre name.
     *
     * @var string
     */
    public $searchName = '';

    /**
     * Minimum number of books for filtering.
     *
     * @var int|null
     */
    public $filterBooksFrom = null;

    /**
     * Maximum number of books for filtering.
     *
     * @var int|null
     */
    public $filterBooksTo = null;

    /**
     * Column to sort by.
     *
     * @var string
     */
    public $sortBy = 'name';

    /**
     * Sort direction.
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listeners = ['genreDeleted' => 'loadGenres', 'genreUpdated' => 'loadGenres', 'genreAdded' => 'loadGenres', 'deleteGenre' => 'delete'];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'genre.name' => 'required|string|max:255|unique:genres,name',
        'searchName' => 'nullable|string|max:255',
        'filterBooksFrom' => 'nullable|integer|min:0',
        'filterBooksTo' => 'nullable|integer|min:0',
    ];

    /**
     * Custom error messages.
     *
     * @var array
     */
    protected $messages = [
        'genre.name.required' => 'The name field is required.',
        'genre.name.string' => 'The name must be a string.',
        'genre.name.max' => 'The name may not be greater than 255 characters.',
        'genre.name.unique' => 'This genre already exists.',
    ];

    /**
     * Mount the component and load the initial list of genres.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->loadGenres();
    }

    /**
     * Sort genres by the given column
     *
     * @param string $column The column to sort by
     * @return void
     */
    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $column;
        $this->loadGenres();
    }

    /**
     * Load genres based on current filters and sorting
     *
     * @return void
     */
    public function loadGenres(): void
    {
        $this->genres = Genre::withCount('books')
            ->when($this->searchName, function ($query, $searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            })
            ->when($this->filterBooksFrom, function ($query, $filterBooksFrom) {
                $query->has('books', '>=', $filterBooksFrom);
            })
            ->when($this->filterBooksTo, function ($query, $filterBooksTo) {
                $query->has('books', '<=', $filterBooksTo);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        $this->emit('genresLoaded');
    }

    /**
     * Show the form for creating a new genre
     *
     * @return void
     */
    public function create(): void
    {
        $this->resetAll();
        $this->editMode = false;
        $this->showForm = true;
    }

    /**
     * Store a new genre in the database
     *
     * @return void
     */
    public function store(): void
    {
        $this->validate();

        try {
            Genre::create($this->genre);
            $this->successMessage = 'Genre added successfully!';
            $this->emit('genreAdded');
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->showForm = false;
            $this->loadGenres();
            $this->resetErrorBag();
        }
    }

    /**
     * Show the form for editing an existing genre
     *
     * @param Genre $genre The genre to edit
     * @return void
     */
    public function edit(Genre $genre): void
    {
        $this->resetAll();
        $this->genre = $genre->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    /**
     * Update an existing genre in the database
     *
     * @return void
     */
    public function update(): void
    {
        $this->validate();

        try {
            $genre = Genre::find($this->genre['id']);
            $genre->update($this->genre);
            $this->successMessage = 'Genre updated successfully!';
            $this->emit('genreUpdated');
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->showForm = false;
            $this->loadGenres();
            $this->resetErrorBag();
        }
    }

    /**
     * Delete a genre from the database
     *
     * @param Genre $genre The genre to delete
     * @return void
     */
    public function delete(Genre $genre): void
    {
        try {
            if ($genre->books()->count() > 0) {
                $this->errorMessages[] = 'Cannot delete genre with associated books.';
            } else {
                $genre->delete();
                $this->successMessage = 'Genre deleted successfully!';
                $this->emit('genreDeleted');
            }
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->loadGenres();
        }
    }

    /**
     * Reset all form fields and messages
     *
     * @return void
     */
    private function resetFormAndLoadGenres(): void
    {
        $this->reset(['searchName', 'filterBooksFrom', 'filterBooksTo']);
        $this->loadGenres();
    }


    public function resetAll(): void
    {
        $this->resetErrorBag();
        $this->reset(['genre', 'editMode', 'successMessage', 'errorMessages']);
    }

    /**
     * Reset filters and reload genres
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->reset(['searchName', 'filterBooksFrom', 'filterBooksTo']);
        $this->loadGenres();
    }

    /**
     * Cancel form editing
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->resetAll();
        $this->showForm = false;
    }

    /**
     * Handle errors and log them
     *
     * @param string $action The action that caused the error
     * @param \Exception $exception The exception that was thrown
     * @return void
     */
    private function handleError(string $action, \Exception $exception): void
    {
        Log::error('Error ' . $action . ' genre:', ['exception' => $exception]);
        $this->errorMessages[] = 'An error occurred while ' . $action . ' the genre. Please try again.';
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.genres.index', [
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
            'genres' => $this->genres,
            'showForm' => $this->showForm,
        ]);
    }
}
