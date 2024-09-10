<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Log;

class Books extends Component
{
    public $books = [];
    public $book;
    public $editMode = false;
    public $isModalOpen = false;


    protected $listeners = ['bookDeleted' => 'loadBooks'];

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
        $this->isModalOpen = true;
        $this->emit('openModal');
    }


    public function store()
    {

        try {
            $this->validate(app(StoreBookRequest::class)->rules());
            Book::create($this->book);
            $this->showModal = false;
            $this->emit('bookAdded');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'Database error: ' . $e->getMessage());
            Log::error('Error adding book:', ['exception' => $e]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while adding the book.');
            Log::error('Error adding book:', ['exception' => $e]);
        } finally {
            $this->isModalOpen = false;
            $this->loadBooks();
        }


    }

    public function edit(Book $book)
    {
        $this->book = $book;
        $this->editMode = true;
        $this->isModalOpen = true;
    }

    public function update()
    {
        try {
            $this->validate(UpdateBookRequest::rules());
            $this->book->save();
            $this->showModal = false;
            $this->emit('bookUpdated');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'Database error: ' . $e->getMessage());
            Log::error('Error updating book:', ['exception' => $e]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the book.');
            Log::error('Error updating book:', ['exception' => $e]);
        } finally {
            $this->isModalOpen = false;
            $this->loadBooks();
        }
    }

    public function delete(Book $book)
    {
        try {
            $book->delete();
            $this->emit('bookDeleted');
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', 'Database error: ' . $e->getMessage());
            Log::error('Error deleting book:', ['exception' => $e]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the book.');
            Log::error('Error deleting book:', ['exception' => $e]);
        } finally {
            $this->loadBooks();
        }
    }

    public function render()
    {
//        return view('livewire.books');
        return view('livewire.books', [
            'isModalOpen' => $this->showModal, // Pass the modal state to the view
        ]);
//        return view('livewire.books')->layout('layouts.app', ['title' => $this->books]);
    }
}






