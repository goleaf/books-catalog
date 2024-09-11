<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    {{-- Using LaravelCollective's Form builder --}}
                    {!! Form::open(['wire:submit.prevent' => $editMode ? 'update' : 'store']) !!}
                    @csrf

                    <div class="mb-3">
                        {!! Form::label('title', __('Title'), ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('book.title') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.title', 'required']) !!}
                        @error('book.title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('author_id', __('Author'), ['class' => 'form-label']) !!}
                        {!! Form::select('author_id', $authors, null, ['class' => 'form-select' . ($errors->has('book.author_id') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.author_id', 'required']) !!}
                        @error('book.author_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('isbn', __('ISBN'), ['class' => 'form-label']) !!}
                        {!! Form::text('isbn', null, ['class' => 'form-control' . ($errors->has('book.isbn') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.isbn', 'required']) !!}
                        @error('book.isbn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('publication_date', __('Publication date'), ['class' => 'form-label']) !!}
                        {!! Form::date('publication_date', null, ['class' => 'form-control' . ($errors->has('book.publication_date') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.publication_date', 'required']) !!}
                        @error('book.publication_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('genre_id', __('Genre'), ['class' => 'form-label']) !!}
                        {!! Form::select('genre_id', $genres, null, ['class' => 'form-select' . ($errors->has('book.genre_id') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.genre_id', 'required']) !!}
                        @error('book.genre_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        {!! Form::label('number_of_copies', __('Number of copies'), ['class' => 'form-label']) !!}
                        {!! Form::number('number_of_copies', null, ['class' => 'form-control' . ($errors->has('book.number_of_copies') ? ' is-invalid' : ''), 'wire:model.defer' => 'book.number_of_copies', 'required']) !!}
                        @error('book.number_of_copies') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
</div>
