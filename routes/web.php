<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Logout;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Books;
use App\Http\Livewire\Authors;
use App\Http\Livewire\Genres;
use App\Http\Livewire\Users;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('books.index') : redirect()->route('login');
});

Route::match(['get', 'post'], 'login', Login::class)
    ->name('login');

Route::post('logout', Logout::class)
    ->name('logout');

Route::get('register', Register::class)
    ->name('register');

Route::get('/books', Books::class)->name('books.index')->middleware('auth');
Route::get('/authors', Authors::class)->name('authors.index')->middleware('auth');
Route::get('/genres', Genres::class)->name('genres.index')->middleware('auth');

Route::get('/users', Users::class)->name('users.index')->middleware('auth');
