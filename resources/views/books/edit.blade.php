@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Edit Book</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="isbn">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="publication_date">Publication date</label>
                                <input type="date" class="form-control" id="publication_date" name="publication_date" value="{{ old('publication_date', $book->publication_date) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $book->genre) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="number_of_copies">Number of copies</label>
                                <input type="number" class="form-control" id="number_of_copies" name="number_of_copies" value="{{ old('number_of_copies', $book->number_of_copies) }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection