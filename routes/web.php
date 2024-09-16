<?php

use App\Http\Controllers\LoginRegisterController;
use Illuminate\Support\Facades\Route;
//use App\Http\Livewire\Auth\Login;
//use App\Http\Livewire\Auth\Logout;
//use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Books;
use App\Http\Livewire\Authors;
use App\Http\Livewire\Genres;
use App\Http\Livewire\Users;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('books.index') : redirect()->route('auth.login');
});

//Route::match(['get', 'post'], 'login', Login::class)->name('login');
//Route::post('logout', Logout::class)->name('logout');
//Route::match(['get', 'post'], 'register', Register::class)->name('register');


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('auth.register');
    Route::post('/register', 'register')->name('auth.register');
    Route::post('/store', 'store')->name('auth.store');
    Route::get('/store', 'store')->name('auth.store');
    Route::get('/login', 'login')->name('auth.login');
    Route::post('/authenticate', 'authenticate')->name('auth.authenticate');
    Route::get('/dashboard', 'dashboard')->name('auth.dashboard');
    Route::post('/logout', 'logout')->name('auth.logout');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/books', function () {
        return view('modules.books');
    })->name('books.index')->middleware('auth');

    Route::get('/authors', Authors::class)->name('authors.index')->middleware('auth');
    Route::get('/genres', Genres::class)->name('genres.index')->middleware('auth');
    Route::get('/users', Users::class)->name('users.index')->middleware('auth');


});

