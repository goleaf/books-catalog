@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Register New Book</h1>
        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="publication_date">Publication date</label>
                <input type="date" class="form-control" id="publication_date" name="publication_date" required>
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="form-group">
                <label for="number_of_copies">Number of copies</label>
                <input type="number" class="form-control" id="number_of_copies" name="number_of_copies" required>
            </div>
            <button type="submit" class="btn btn-primary">Register Book</button>
        </form>
    </div>
@endsection
