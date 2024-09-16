<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Author;
use Illuminate\Support\Facades\Log;

class Authors extends Component
{
    public $authors = [];
    public $author;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    protected $listeners = ['authorDeleted' => 'loadAuthors'];

    protected $rules = [
        'author.name' => 'required|string|max:255|unique:authors,name',
    ];

    protected $messages = [
        'author.name.required' => 'The name field is required.',
        'author.name.string' => 'The name must be a string.',
        'author.name.max' => 'The name may not be greater than 255 characters.',
        'author.name.unique' => 'This author already exists.',
    ];

    public function mount()
    {
        $this->loadAuthors();
    }

    public function loadAuthors()
    {
        $this->authors = Author::all();
    }

    public function create()
    {
        $this->reset(['author', 'editMode']);
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        try {
            Author::create($this->author);
            $this->successMessage = 'Author added successfully!';
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->resetFormAndLoadAuthors();
        }
    }

    public function edit(Author $author)
    {
        $this->author = $author->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        try {
            $author = Author::findOrFail($this->author['id']);
            $author->update($this->author);
            $this->successMessage = 'Author updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->resetFormAndLoadAuthors();
        }
    }

    public function delete(Author $author)
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
            $this->loadAuthors();
        }
    }

    private function handleError($action, $exception)
    {
        $this->errorMessages[] = 'Error ' . $action . ' author.';
        Log::error('Error ' . $action . ' author:', ['exception' => $exception]);
    }

    private function resetFormAndLoadAuthors(): void
    {
        $this->reset(['author', 'editMode', 'errorMessages']);
        $this->showForm = false;
        $this->loadAuthors();
    }

    public function render()
    {
        return view('livewire.authors.index');
    }
}
