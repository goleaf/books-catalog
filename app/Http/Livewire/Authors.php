<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Author;
use Illuminate\Support\Facades\Log;

/**
 * Livewire component for managing authors.
 *
 * This component handles the display, creation, editing, and deletion of author records.
 */
class Authors extends Component
{
    /**
     * The collection of authors to display in the list.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $authors = [];

    /**
     * The current author being edited or added.
     * This is an associative array representing the author's attributes.
     *
     * @var array|null
     */
    public $author;

    /**
     * Flag to control the visibility of the author form.
     *
     * @var bool
     */
    public $showForm = false;

    /**
     * Flag to indicate if the form is in edit mode.
     *
     * @var bool
     */
    public $editMode = false;

    /**
     * Success message to be displayed after a successful operation.
     *
     * @var string
     */
    public $successMessage = '';

    /**
     * Array to store error messages.
     *
     * @var array
     */
    public $errorMessages = [];

    /**
     * Search term for the author name.
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
     * The column to sort the author list by.
     *
     * @var string
     */
    public $sortBy = 'name';

    /**
     * The sorting direction ('asc' or 'desc').
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * Events this component listens for.
     *
     * @var array
     */
    protected $listeners = ['authorDeleted' => 'loadAuthors', 'authorUpdated' => 'loadAuthors', 'authorAdded' => 'loadAuthors', 'deleteAuthor' => 'delete'];

    /**
     * Validation rules for the author form.
     *
     * @var array
     */
    protected array $rules = [
        'author.name' => 'required|string|max:255',
        'author.biography' => 'nullable|string',
        'searchName' => 'nullable|string|max:255',
        'filterBooksFrom' => 'nullable|integer|min:0',
        'filterBooksTo' => 'nullable|integer|min:0',
    ];

    /**
     * Initialize the component and load the initial list of authors
     *
     * @return void
     */
    public function mount(): void
    {
        $this->loadAuthors();
    }

    /**
     * Sort authors by the given column
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
        $this->loadAuthors();
    }

    /**
     * Load authors based on current filters and sorting
     *
     * @return void
     */
    public function loadAuthors(): void
    {
        $this->authors = Author::withCount('books')
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

        $this->emit('authorsLoaded');
    }

    /**
     * Prepare to create a new author
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
     * Store a new author in the database
     *
     * @return void
     */
    public function store(): void
    {
        $this->validate();

        try {
            Author::create($this->author);
            $this->successMessage = 'Author added successfully!';
            $this->emit('authorAdded');
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->showForm = false;
            $this->loadAuthors();
            $this->resetErrorBag();
        }
    }

    /**
     * Prepare to edit an existing author
     *
     * @param Author $author The author to edit
     * @return void
     */
    public function edit(Author $author): void
    {
        $this->resetAll();
        $this->author = $author->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    /**
     * Update an existing author in the database
     *
     * @return void
     */
    public function update(): void
    {
        $this->validate();

        try {
            $author = Author::find($this->author['id']);
            $author->update($this->author);
            $this->successMessage = 'Author updated successfully!';
            $this->emit('authorUpdated');
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->showForm = false;
            $this->loadAuthors();
            $this->resetErrorBag();
        }
    }

    /**
     * Delete an author from the database
     *
     * @param Author $author The author to delete
     * @return void
     */
    public function delete(Author $author): void
    {
        try {
            if ($author->books()->count() > 0) {
                $this->errorMessages[] = 'Cannot delete author with associated books.';
            } else {
                $author->delete();
                $this->successMessage = 'Author deleted successfully!';

            }
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->emit('authorDeleted');
            $this->loadAuthors();
        }
    }

    /**
     * Reset all form fields and messages
     *
     * @return void
     */
    public function resetAll(): void
    {
        $this->resetErrorBag();
        $this->reset(['author', 'editMode', 'successMessage', 'errorMessages']);
    }

    /**
     * Reset filters and reload authors
     *
     * @return void
     */
    public function resetFilters(): void
    {
        $this->reset(['searchName', 'filterBooksFrom', 'filterBooksTo']);
        $this->loadAuthors();
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
        Log::error('Error ' . $action . ' author:', ['exception' => $exception]);
        $this->errorMessages[] = 'An error occurred while ' . $action . ' the author. Please try again.';
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.authors.index', [
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
            'authors' => $this->authors,
            'showForm' => $this->showForm,
        ]);
    }
}
