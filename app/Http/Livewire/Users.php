<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Users extends Component
{
    public $users = [];
    public $user;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    public $password = '';
    public $password_confirmation = '';

    protected $listeners = ['userDeleted' => 'loadUsers'];

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|string|email|max:255',
    ];

    protected $messages = [
        'user.name.required' => 'The name field is required.',
        'user.name.string' => 'The name must be a string.',
        'user.name.max' => 'The name may not be greater than 255 characters.',

        'user.email.required' => 'The email field is required.',
        'user.email.string' => 'The email must be a string.',
        'user.email.email' => 'The email must be a valid email address.',
        'user.email.max' => 'The email may not be greater than 255 characters.',
    ];

    public function mount()
    {
        $this->authorize('manage-users');
        $this->loadUsers();
    }

    public function loadUsers(): void
    {
        $this->users = User::all();
    }

    public function sortBy($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->loadUsers();
    }

    public function create(): void
    {
        $this->authorize('manage-users');
        $this->resetAll();
        $this->editMode = false;
        $this->showForm = true;
    }

    public function store(): void
    {
        $this->rules['password'] = 'required|string|min:8|confirmed';
        $this->validate();

        $this->validate(['user.email' => 'unique:users']);

        try {
            User::create([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'password' => Hash::make($this->password),
            ]);
            $this->successMessage = 'User added successfully!';
        } catch (\Exception $e) {
            $this->handleError('adding', $e);
        } finally {
            $this->showForm = false;
            $this->loadUsers();
            $this->resetErrorBag();
        }
    }

    public function edit(User $user): void
    {
        $this->authorize('manage-users');
        $this->resetAll();
        $this->user = $user->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update(): void
    {
        $this->authorize('manage-users');

        $this->validate();

        if ($this->password) {
            $this->validate(['password' => 'string|min:8|confirmed']);
            $this->user['password'] = Hash::make($this->password);
        } else {
            unset($this->user['password']);
        }

        $this->validate([
            'user.email' => Rule::unique('users')->ignore($this->user['id']),
        ]);

        try {
            $user = User::find($this->user['id']);
            $user->update($this->user);
            $this->successMessage = 'User updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        } finally {
            $this->resetFormAndLoadUsers();
        }
    }

    public function delete(User $user): void
    {
        $this->authorize('manage-users');

        try {
            $user->delete();
            $this->successMessage = 'User deleted successfully!';
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        } finally {
            $this->loadUsers();
        }
    }

    private function resetFormAndLoadUsers(): void
    {
        $this->reset(['user', 'editMode', 'errorMessages', 'password', 'password_confirmation']);
        $this->showForm = false;
        $this->loadUsers();
    }

    public function resetAll(): void
    {
        $this->resetErrorBag();
        $this->reset(['user', 'editMode', 'successMessage', 'errorMessages', 'password', 'password_confirmation']);
    }

    public function cancel(): void
    {
        $this->resetAll();
        $this->showForm = false;
    }

    private function handleError($action, $exception): void
    {
        $this->errorMessages[] = 'Error ' . $action . ' user.';
        Log::error('Error ' . $action . ' user:', ['exception' => $exception]);
    }

    public function render()
    {
        return view('livewire.users.index', [
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
