<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     * Apply guest middleware except for logout method.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     * Validate the request data, create a new user, log them in, and redirect to the books index.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        // Log the user in
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect to the books index
        return redirect()->route('books.index');
    }

    /**
     * Handle the login request.
     * Validate the request data, attempt to authenticate the user, and redirect to the books index if successful.
     * Otherwise, redirect back with an error message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('books.index');
        }

        // Redirect back with an error message if authentication fails
        return back()
            ->withErrors(['email' => 'Your provided credentials do not match in our records.'])
            ->onlyInput('email');
    }

    /**
     * Handle the logout request.
     * Log the user out, invalidate the session, regenerate the CSRF token, and redirect to the login page with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect()->route('auth.login')->withSuccess('You have logged out successfully!');
    }
}
