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

    protected $listeners = ['bookDeleted' => 'loadBooks'];

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

    public function loadBooks(): void
    {
        $this->books = Book::all();
    }

    public function create(): void
    {
        $this->reset('book');
        $this->editMode = false;
        $this->showForm = true;
    }


    public function store(): void
    {
        $this->validate();
        $this->validate(['books.isbn' => 'unique:books']);

        try {
            Book::create($this->book);
            session()->flash('success', 'Book added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding book.');
            Log::error('Error adding book:', ['exception' => $e]);
        } finally {
            $this->showForm = false;
            $this->loadBooks();
            session()->forget('error');
        }
    }

    public function edit(Book $book): void
    {
        $this->book = $book->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->validate([
            'books.isbn' => Rule::unique('books')->ignore($this->book['id']),
        ]);

        try {
            $book = Book::find($this->book['id']);
            $book->update($this->book);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'Database error: ' . $e->getMessage());
            Log::error('Error updating book:', ['exception' => $e]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the book.');
            Log::error('Error updating book:', ['exception' => $e]);
        } finally {
            $this->showForm = false;
            $this->loadBooks();
            session()->flash('success', 'Book updated successfully!');
            session()->forget('error');
        }
    }

    public function delete(Book $book): void
    {
        try {
            $book->delete();
            $this->emit('bookDeleted');
            session()->flash('success', 'Book deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting book: ' . $e->getMessage());
        } finally {
            $this->loadBooks();
        }
    }

    public function cancel(): void
    {
        $this->reset(['book', 'editMode']);
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.books');
    }
}
