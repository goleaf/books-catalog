<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Books extends Component
{
    public $books = [];
    public $book;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    // Search and filter properties
    public $searchTitle = '';
    public $searchAuthor = '';
    public $searchIsbn = '';
    public $filterGenre = '';
    public $filterCopiesFrom = null;
    public $filterCopiesTo = null;
    public $sortBy = 'title';
    public $sortDirection = 'asc';
    public $filterPublicationDateFrom = null;
    public $filterPublicationDateTo = null;

    protected $listeners = ['bookDeleted' => 'loadBooks', 'bookUpdated' => 'loadBooks', 'bookAdded' => 'loadBooks'];

    protected $rules = [
        'book.title' => 'required|string|max:255',
        'book.author' => 'required|string|max:255',
        'book.isbn' => 'required|string|max:13',
        'book.publication_date' => 'required|date',
        'book.genre' => 'required|string|max:255',
        'book.number_of_copies' => 'required|integer',
    ];

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

    public function mount(): void
    {
        $this->loadBooks();
    }

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
    public function loadBooks(): void
    {
        $this->books = Book::query()
            ->when($this->searchTitle, function ($query, $searchTitle) {
                $query->where('title', 'like', '%' . $searchTitle . '%');
            })
            ->when($this->searchAuthor, function ($query, $searchAuthor) {
                $query->where('author', 'like', '%' . $searchAuthor . '%');
            })
            ->when($this->searchIsbn, function ($query, $searchIsbn) {
                $query->where('isbn', 'like', '%' . $searchIsbn . '%');
            })
            ->when($this->filterGenre, function ($query, $filterGenre) {
                $query->where('genre', $filterGenre);
            })
            ->when($this->filterCopiesFrom, function ($query, $filterCopiesFrom) {
                $query->where('number_of_copies', '>=', $filterCopiesFrom);
            })
            ->when($this->filterCopiesTo, function ($query, $filterCopiesTo) {
                $query->where('number_of_copies', '<=', $filterCopiesTo);
            })
            ->when($this->filterPublicationDateFrom, function ($query, $date) {
                $query->where('publication_date', '>=', $date);
            })
            ->when($this->filterPublicationDateTo, function ($query, $date) {
                $query->where('publication_date', '<=', $date);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    public function create(): void
    {
        $this->resetAll();
        $this->editMode = false;
        $this->showForm = true;
    }

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

    public function edit(Book $book): void
    {
        $this->resetAll();
        $this->book = $book->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

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

    public function resetAll(): void
    {
        $this->resetErrorBag();
        $this->reset(['book', 'editMode', 'successMessage', 'errorMessages']);
    }

    public function cancel(): void
    {
        $this->resetAll();
        $this->showForm = false;
    }

    private function handleError($action, $exception)
    {
        $this->errorMessages[] = 'Error ' . $action . ' book.';
        Log::error('Error ' . $action . ' book:', ['exception' => $exception]);
    }

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
