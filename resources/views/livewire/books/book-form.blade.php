<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['wire:submit.prevent' => $editMode ? 'update' : 'store']) !!}
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            {!! Form::label('title', __('Title'), ['class' => 'form-label fw-bold']) !!}
                            {!! Form::text('title', $editMode ? $book['title'] : null,
                                ['class' => 'form-control' . ($errors->has('book.title') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.title', 'required']) !!}
                            @error('book.title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            {!! Form::label('isbn', __('ISBN'), ['class' => 'form-label fw-bold']) !!}
                            {!! Form::text('isbn', $editMode ? $book['isbn'] : null,
                                ['class' => 'form-control' . ($errors->has('book.isbn') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.isbn', 'required']) !!}
                            @error('book.isbn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            {!! Form::label('publication_date', __('Publication date'), ['class' => 'form-label fw-bold']) !!}
                            {!! Form::date('publication_date', $editMode ? $book['publication_date'] : null,
                                ['class' => 'form-control' . ($errors->has('book.publication_date') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.publication_date', 'required']) !!}
                            @error('book.publication_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            {!! Form::label('number_of_copies', __('Number of copies'), ['class' => 'form-label fw-bold']) !!}
                            {!! Form::number('number_of_copies', $editMode ? $book['number_of_copies'] : null,
                                ['class' => 'form-control' . ($errors->has('book.number_of_copies') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.number_of_copies', 'required']) !!}
                            @error('book.number_of_copies') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            {!! Form::label('authors[]', __('Authors'), ['class' => 'form-label fw-bold']) !!}
                            <div class="form-check">
                                @foreach ($authors as $id => $name)
                                    <div>
                                        {!! Form::checkbox('authors[]', $id, in_array($id, $selectedAuthors),
                                            ['class' => 'form-check-input', 'id' => 'author_' . $id, 'wire:model.defer' => 'selectedAuthors']) !!}
                                        {!! Form::label('author_' . $id, $name, ['class' => 'form-check-label']) !!}
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedAuthors') <span class="text-danger">{{ $message }}</span> @enderror
                            @error('selectedAuthors.*') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            {!! Form::label('genres[]', __('Genres'), ['class' => 'form-label fw-bold']) !!}
                            <div class="form-check">
                                @foreach ($genres as $id => $label)
                                    <div>
                                        {!! Form::checkbox('genres[]', $id, in_array($id, $selectedGenres),
                                            ['class' => 'form-check-input', 'id' => 'genre_' . $id, 'wire:model.defer' => 'selectedGenres']) !!}
                                        {!! Form::label('genre_' . $id, $label, ['class' => 'form-check-label']) !!}
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedGenres') <span class="text-danger">{{ $message }}</span> @enderror
                            @error('selectedGenres.*') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    {!! Form::submit($editMode ? 'Update' : 'Add', ['class' => 'btn ' . ($editMode ? 'btn-primary' : 'btn-success')]) !!}
                    <button type="button" class="btn btn-secondary" wire:click="cancel">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
