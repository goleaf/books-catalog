@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $book->title }}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                        <p><strong>Publication Date:</strong> {{ $book->publication_date->format('F j, Y') }}</p>
                        <p><strong>Genre:</strong> {{ $book->genre }}</p>
                        <p><strong>Number of Copies:</strong> {{ $book->number_of_copies }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('books.index') }}" class="btn btn-primary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
