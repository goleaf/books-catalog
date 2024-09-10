@if ($books->isEmpty())
    <p>No books found.</p>
@else
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Publication Date</th>
            <th>Genre</th>
            <th>Number of Copies</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->publication_date }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->number_of_copies }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $book->id }})" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $book->id }})" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this book?')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
