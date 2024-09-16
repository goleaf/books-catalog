<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|min:3|max:250',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            Auth::login($user);

            session()->flash('success', 'Registration successful!');

            $this->reset(['name', 'email', 'password', 'password_confirmation']);
            $this->successMessage = 'Registration successful! You can now use the application.';
        } catch (\Throwable $e) {
            $this->addError('registration', 'An error occurred during registration. Please try again.');
            dump('Error during registration:', ['exception' => $e]);
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
