<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;

class Genres extends Component
{
    public $genres = [];
    public $genre;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    protected $rules = [
        'genre.name' => 'required|string|max:255|unique:genres,name',
    ];

    protected $messages = [
        'genre.name.required' => 'The name field is required.',
        'genre.name.string' => 'The name must be a string.',
        'genre.name.max' => 'The name may not be greater than 255 characters.',
        'genre.name.unique' => 'This genre already exists.',
    ];

    public function mount()
    {
        $this->loadGenres();
    }

    public function loadGenres()
    {
        $this->genres = Genre::all();
    }

    public function create()
    {
        $this->reset(['genre', 'editMode']);
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        try {
            Genre::create($this->genre);
            $this->successMessage = 'Genre added successfully!';
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->showForm = false;
            $this->loadGenres();
            $this->resetErrorBag();
        }
    }

    public function edit(Genre $genre)
    {
        $this->resetAll();
        $this->genre = $genre->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        try {
            $genre = Genre::find($this->genre['id']);
            $genre->update($this->genre);
            $this->successMessage = 'Genre updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->showForm = false;
            $this->loadGenres();
            $this->resetErrorBag();
        }
    }

    public function delete(Genre $genre)
    {
        try {
            $genre->delete();
            $this->successMessage = 'Genre deleted successfully!';
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->loadGenres();
        }
    }

    public function resetAll()
    {
        $this->resetErrorBag();
        $this->reset(['genre', 'editMode', 'successMessage', 'errorMessages']);
    }

    public function cancel()
    {
        $this->resetAll();
        $this->showForm = false;
    }

    private function handleError($action, $exception)
    {
        $this->errorMessages[] = 'Error ' . $action . ' genre.';
        Log::error('Error ' . $action . ' genre:', ['exception' => $exception]);
    }

    public function render()
    {
        return view('livewire.genres');
    }
}
