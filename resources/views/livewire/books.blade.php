<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-book mr-2"></i> Book List</h3>
                </div>
                <div class="card-body">


                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <button wire:click="create" class="btn btn-primary mb-3">
                        <i class="fas fa-plus mr-2"></i> Add New Book
                    </button>


                    @dump($books)

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


                    @if ($showModal)
                        <div class="modal" style="display: block;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">{{ $editMode ? 'Edit Book' : 'Add New Book' }}</h5>
                                        <button type="button" class="close" wire:click="$set('showModal', false)" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" id="title" wire:model="book.title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="author">Author</label>
                                                <input type="text" class="form-control" id="author" wire:model="book.author" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="isbn">ISBN</label>
                                                <input type="text" class="form-control" id="isbn" wire:model="book.isbn" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="publication_date">Publication date</label>
                                                <input type="date" class="form-control" id="publication_date" wire:model="book.publication_date" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="genre">Genre</label>
                                                <input type="text" class="form-control" id="genre" wire:model="book.genre" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="number_of_copies">Number of copies</label>
                                                <input type="number" class="form-control" id="number_of_copies" wire:model="book.number_of_copies" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">{{ $editMode ? 'Update Book' : 'Add Book' }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
