<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * Livewire component for managing books.
 *
 * This component handles the display, creation, editing, and deletion of book records.
 */
class Books extends Component
{
    /**
     * The collection of books to display in the list.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public array|\Illuminate\Database\Eloquent\Collection $books = [];

    /**
     * The current book being edited or added.
     * This is an associative array representing the book's attributes.
     *
     * @var array|null
     */
    public $book;

    /**
     * Flag to control the visibility of the book form.
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

    // Search and filter properties
    /**
     * Search term for the title field.
     *
     * @var string
     */
    public $searchTitle = '';

    /**
     * Search term for the author field.
     *
     * @var string
     */
    public $searchAuthor = '';

    /**
     * Search term for the ISBN field.
     *
     * @var string
     */
    public $searchIsbn = '';

    /**
     * Selected genre for filtering.
     *
     * @var string
     */
    public $filterGenre = '';

    /**
     * Minimum number of copies for filtering.
     *
     * @var int|null
     */
    public $filterCopiesFrom = null;

    /**
     * Maximum number of copies for filtering.
     *
     * @var int|null
     */
    public $filterCopiesTo = null;

    /**
     * The column to sort the book list by.
     *
     * @var string
     */
    public $sortBy = 'title';

    /**
     * The sorting direction ('asc' or 'desc').
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * Start date for publication date filtering.
     *
     * @var string|null (date in Y-m-d format)
     */
    public $filterPublicationDateFrom = null;

    /**
     * End date for publication date filtering.
     *
     * @var string|null (date in Y-m-d format)
     */
    public $filterPublicationDateTo = null;

    /**
     * Events this component listens for.
     *
     * @var array
     */
    protected $listeners = ['bookDeleted' => 'loadBooks', 'bookUpdated' => 'loadBooks', 'bookAdded' => 'loadBooks'];

    /**
     * Validation rules for the book form.
     *
     * @var array
     */
    protected $rules = [
        'book.title' => 'required|string|max:255',
        'book.author' => 'required|string|max:255',
        'book.isbn' => 'required|string|max:13',
        'book.publication_date' => 'required|date',
        'book.genre' => 'required|string|max:255',
        'book.number_of_copies' => 'required|integer',
    ];

    /**
     * Custom validation error messages.
     *
     * @var array
     */
    protected $messages = [
        'book.title.required' => 'The title field is required.',
        'book.title.string' => 'The title must be a string.',
        'book.title.max' => 'The title may not be greater than 255 characters.',

        'book.author.required' => 'The author field is required.',
        'book.author.string' => 'The author must be a string.',
        'book.author.max' => 'The author may not be greater than 255 characters.',

        'book.isbn.required' => 'The ISBN field is required.',
        'book.isbn.string' => 'The ISBN must be a string.',
        'book.isbn.max' => 'The ISBN may not be greater than 13 characters.',

        'book.publication_date.required' => 'The publication date field is required.',
        'book.publication_date.date' => 'The publication date must be a valid date.',

        'book.genre.required' => 'The genre field is required.',
        'book.genre.string' => 'The genre must be a string.',
        'book.genre.max' => 'The genre may not be greater than 255 characters.',

        'book.number_of_copies.required' => 'The number of copies field is required.',
        'book.number_of_copies.integer' => 'The number of copies must be an integer.',
    ];

    /**
     * Mount the component and load the initial book list.
     */
    public function mount(): void
    {
        $this->loadBooks();
    }

    /**
     * Sort the book list by the specified column.
     *
     * @param string $column The column to sort by
     */
    public function sortBy($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->loadBooks();
    }

    /**
     * Reset all search and filter inputs.
     */
    public function resetFilters(): void
    {
        $this->reset([
            'searchTitle',
            'searchAuthor',
            'searchIsbn',
            'filterGenre',
            'filterCopiesFrom',
            'filterCopiesTo',
            'filterPublicationDateFrom',
            'filterPublicationDateTo'
        ]);

        $this->loadBooks();
    }

    /**
     * Load the book list from the database, applying sorting and filtering.
     */
    public function loadBooks(): void
    {
        $query = Book::query()
            ->when($this->searchTitle, callback: function ($query, $searchTitle) {
                $query->where('title', 'like', '%' . $searchTitle . '%');
            })
            ->when($this->searchAuthor, callback: function ($query, $searchAuthor) {
                $query->where('author', 'like', '%' . $searchAuthor . '%');
            })
            ->when($this->searchIsbn, callback: function ($query, $searchIsbn) {
                $query->where('isbn', 'like', '%' . $searchIsbn . '%');
            })
            ->when($this->filterGenre, callback: function ($query, $filterGenre) {
                $query->where('genre', $filterGenre);
            })
            ->when($this->filterCopiesFrom, callback: function ($query, $filterCopiesFrom) {
                $query->where('number_of_copies', '>=', $filterCopiesFrom);
            })
            ->when($this->filterCopiesTo, callback: function ($query, $filterCopiesTo) {
                $query->where('number_of_copies', '<=', $filterCopiesTo);
            })
            ->when($this->filterPublicationDateFrom, callback: function ($query, $date) {
                $query->where('publication_date', '>=', $date);
            })
            ->when($this->filterPublicationDateTo, callback: function ($query, $date) {
                $query->where('publication_date', '<=', $date);
            });

        $this->books = $query->orderBy($this->sortBy, $this->sortDirection)
            ->get();

    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): void
    {
        $this->resetAll();
        $this->editMode = false;
        $this->showForm = true;
    }

    /**
     * Store a new book in the database.
     */
    public function store(): void
    {
        $this->validate();
        $this->validate(['book.isbn' => 'unique:books']);

        try {
            Book::create($this->book);
            $this->successMessage = 'Book added successfully!';
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->showForm = false;
            $this->loadBooks();
            $this->resetErrorBag();
        }
    }

    /**
     * Show the form for editing an existing book.
     *
     * @param Book $book The book to edit
     */
    public function edit(Book $book): void
    {
        $this->resetAll();
        $this->book = $book->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    /**
     * Update an existing book in the database.
     */
    public function update(): void
    {
        $this->validate();

        try {
            $book = Book::find($this->book['id']);
            $book->update($this->book);
            $this->successMessage = 'Book updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->showForm = false;
            $this->loadBooks();
            $this->resetErrorBag();
        }
    }

    /**
     * Delete a book from the database.
     *
     * @param Book $book The book to delete
     */
    public function delete(Book $book): void
    {
        try {
            $book->delete();
            $this->emit('bookDeleted');
            $this->successMessage = 'Book deleted successfully!';
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->loadBooks();
        }
    }

    /**
     * Reset all form data, error messages, and success messages.
     */
    public function resetAll(): void
    {
        $this->resetErrorBag();
        $this->reset(['book', 'editMode', 'successMessage', 'errorMessages']);
    }

    /**
     * Cancel the form and return to the book list.
     */
    public function cancel(): void
    {
        $this->resetAll();
        $this->showForm = false;
    }

    /**
     * Handle errors that occur during book operations.
     *
     * @param string $action The action that triggered the error (e.g., 'adding', 'updating', 'deleting')
     * @param \Exception $exception The exception object
     */
    private function handleError($action, $exception): void
    {
        $this->errorMessages[] = 'Error ' . $action . ' book.';
        Log::error('Error ' . $action . ' book:', ['exception' => $exception]);
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Fetch genres with book counts
        $genresWithCounts = Book::query()
            ->select('genre')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('genre')
            ->orderBy('genre')
            ->get();

        $genres = [];
        foreach ($genresWithCounts as $genreWithCount) {
            $genres[$genreWithCount->genre] = $genreWithCount->genre . ' (' . $genreWithCount->count . ' books)';
        }

        return view('livewire.books', [
            'genres' => $genres,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
