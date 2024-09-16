<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email;
    public string $password;
    public bool $remember = false;
    public array $errorMessages = [];


    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->intended(route('books.index'));
        } else {
            $this->errorMessages[] = 'The provided credentials do not match our records.';
        }

    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
