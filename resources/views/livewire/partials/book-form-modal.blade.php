@if ($isModalOpen)
    <div class="modal fade {{ $isModalOpen ? 'show' : '' }}"
         id="addBookModal"
         tabindex="-1"
         aria-labelledby="addBookModalLabel"
         aria-hidden="true"
         style="{{ $isModalOpen ? 'display: block;' : '' }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">{{ $editMode ? 'Edit Book' : 'Add New Book' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="$set('showModal', false)"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" wire:model="book.title" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" wire:model="book.author" required>
                        </div>
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" wire:model="book.isbn" required>
                        </div>
                        <div class="mb-3">
                            <label for="publication_date" class="form-label">Publication date</label>
                            <input type="date" class="form-control" id="publication_date"
                                   wire:model="book.publication_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="genre" wire:model="book.genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="number_of_copies" class="form-label">Number of copies</label>
                            <input type="number" class="form-control" id="number_of_copies"
                                   wire:model="book.number_of_copies" required>
                        </div>
                        <button type="submit"
                                class="btn btn-primary">{{ $editMode ? 'Update Book' : 'Add Book' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif


