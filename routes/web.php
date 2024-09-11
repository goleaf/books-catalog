<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Books;
use App\Http\Livewire\Login;
use App\Http\Livewire\Register;

//Route::get('/books', Books::class)->name('books.index')->middleware('auth');

Route::get('/', function () {
    return view('books.index');
})->name('books.index');//->middleware('auth');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');





