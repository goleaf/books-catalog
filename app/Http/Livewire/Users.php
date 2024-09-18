<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

/**
 * Livewire component for managing users.
 *
 * @package App\Http\Livewire
 */
class Users extends Component
{
    public $users = [];
    public $user;
    public $showForm = false;
    public $editMode = false;
    public $successMessage = '';
    public $errorMessages = [];

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|max:255',
        'user.password' => 'required|min:8',
    ];

    protected $messages = [
        'user.name.required' => 'The name field is required.',
        'user.name.max' => 'The name must not exceed 255 characters.',
        'user.email.required' => 'The email field is required.',
        'user.email.email' => 'Please enter a valid email address.',
        'user.email.max' => 'The email must not exceed 255 characters.',
        'user.password.required' => 'The password field is required.',
        'user.password.min' => 'The password must be at least 8 characters long.',
    ];

    protected $listeners = ['deleteUser' => 'delete'];

    /**
     * Prepare the component for user creation.
     *
     * @return void
     */
    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    /**
     * Store a newly created user in the database.
     *
     * @return void
     */
    public function store()
    {
        try {
            $this->validate();
            $this->user['password'] = Hash::make($this->user['password']);
            User::create($this->user);
            $this->resetForm();
            $this->successMessage = 'User added successfully!';
        } catch (\Exception $e) {
            $this->handleError('creating', $e);
        }
    }

    /**
     * Prepare the component for user editing.
     *
     * @param int $id The ID of the user to edit.
     * @return void
     */
    public function edit($id)
    {
        $this->resetForm();
        $this->user = User::findOrFail($id)->toArray();
        $this->editMode = true;
        $this->showForm = true;
    }

    /**
     * Update the specified user in the database.
     *
     * @return void
     */
    public function update()
    {
        try {
            $this->validate([
                'user.name' => 'required|string|max:255',
                'user.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user['id'])],
                'user.password' => 'nullable|min:8',
            ]);

            $user = User::findOrFail($this->user['id']);
            $user->name = $this->user['name'];
            $user->email = $this->user['email'];

            if (!empty($this->user['password'])) {
                $user->password = Hash::make($this->user['password']);
            }

            $user->save();

            $this->resetForm();
            $this->successMessage = 'User updated successfully!';
        } catch (\Exception $e) {
            $this->handleError('updating', $e);
        }
    }

    /**
     * Delete the specified user from the database.
     *
     * @param int $id The ID of the user to delete.
     * @return void
     */
    public function delete($id)
    {
        try {
            if ($id === auth()->id()) {
                $this->errorMessages[] = 'You cannot delete your own account.';
                return;
            }
            $user = User::findOrFail($id);
            $user->delete();
            $this->successMessage = 'User deleted successfully!';
        } catch (\Exception $e) {
            $this->handleError('deleting', $e);
        }
    }

    /**
     * Reset the form and clear any error messages.
     *
     * @return void
     */
    private function resetForm()
    {
        $this->user = [];
        $this->showForm = false;
        $this->editMode = false;
        $this->errorMessages = [];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /**
     * Cancel the current operation and reset the form.
     *
     * @return void
     */
    public function cancel()
    {
        $this->resetForm();
    }

    /**
     * Handle errors and log them.
     *
     * @param string $action The action that caused the error.
     * @param \Exception $exception The exception that was thrown.
     * @return void
     */
    private function handleError(string $action, \Exception $exception): void
    {
        Log::error('Error ' . $action . ' user:', ['exception' => $exception]);
        $this->errorMessages[] = 'An error occurred while ' . $action . ' the user. Please try again.';
    }

    /**
     * Render the users component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->users = User::all();
        return view('livewire.users.index');
    }
}
