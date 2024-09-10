<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;

class Books extends Component
{
    public $books, $book,  
 $showModal = false, $editMode = false;

    protected $rules = [

    ];

    public function mount()
    {
        $this->loadBooks();
    }

    public function loadBooks()
    {
        $this->books = Book::all();
    }

    public function create()
    {
        $this->reset(['book', 'editMode']);
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        Book::create($this->book);

        $this->showModal = false;
        $this->loadBooks();
    }

    public function edit(Book $book)
    {
        $this->book = $book;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $this->book->save();

        $this->showModal = false;
        $this->loadBooks();
    }

    public function delete(Book $book)
    {
        $book->delete();
        $this->loadBooks();
    }

    public function render()
    {
        return view('livewire.books');
    }
}
