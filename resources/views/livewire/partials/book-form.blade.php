<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="text" class="form-control @error('book.title') is-invalid @enderror" id="title" wire:model="book.title">
                            @error('book.title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">{{ __('Author') }}</label>
                            <input type="text" class="form-control @error('book.author') is-invalid @enderror" id="author" wire:model="book.author">
                            @error('book.author') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isbn" class="form-label">{{ __('ISBN') }}</label>
                            <input type="text" class="form-control @error('book.isbn') is-invalid @enderror" id="isbn" wire:model="book.isbn">
                            @error('book.isbn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publication_date" class="form-label">{{ __('Publication date') }}</label>
                            <input type="date" class="form-control @error('book.publication_date') is-invalid @enderror" id="publication_date" wire:model="book.publication_date">
                            @error('book.publication_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">{{ __('Genre') }}</label>
                            <input type="text" class="form-control @error('book.genre') is-invalid @enderror" id="genre" wire:model="book.genre">
                            @error('book.genre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="number_of_copies" class="form-label">{{ __('Number of copies') }}</label>
                            <input type="number" class="form-control @error('book.number_of_copies') is-invalid @enderror" id="number_of_copies" wire:model="book.number_of_copies">
                            @error('book.number_of_copies') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn {{ $editMode ? 'btn-primary' : 'btn-success' }}">
                                @if($editMode)
                                    <i class="fas fa-save mr-2"></i> Update
                                @else
                                    <i class="fas fa-plus mr-2"></i> Add
                                @endif
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="cancel">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
