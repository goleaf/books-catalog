<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Books;

//Route::get('/', Books::class)->name('books.index');

Route::get('/', function () {
    return view('books.index');
})->name('books.index');

/*
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/', [BookController::class, 'store'])->name('books.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});
*/
