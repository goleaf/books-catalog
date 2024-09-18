@if ($books->isEmpty())
    <p>No books found.</p>
@else
    <table class="table table-hover align-middle table-responsive">
        <thead>
        <tr class="filters">
            <td>
                {!! Form::text('searchTitle', $searchTitle,
                    ['class' => 'form-control form-control-sm', 'placeholder' => 'Search by title...',
                    'wire:model.debounce.500ms' => 'searchTitle',
                    'wire:keydown.enter' => 'loadBooks']) !!}
                @error('searchTitle') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                {!! Form::select('filterAuthor', $authors, $filterAuthor,
                    ['class' => 'form-select form-select-sm', 'wire:model' => 'filterAuthor','placeholder' => 'Select author']) !!}
                @error('filterAuthor') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                {!! Form::text('searchIsbn', $searchIsbn,
                    ['class' => 'form-control form-control-sm', 'placeholder' => 'Search by ISBN...',
                    'wire:model.debounce.500ms' => 'searchIsbn',
                    'wire:keydown.enter' => 'loadBooks']) !!}
                @error('searchIsbn') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                <div class="d-flex flex-column">
                    {!! Form::date('filterPublicationDateFrom', $filterPublicationDateFrom,
                        ['class' => 'form-control form-control-sm mt-1', 'placeholder' => 'From...',
                        'wire:model.defer' => 'filterPublicationDateFrom',
                        'wire:keydown.enter' => 'loadBooks']) !!}
                    @error('filterPublicationDateFrom') <span class="text-danger">{{ $message }}</span> @enderror
                    {!! Form::date('filterPublicationDateTo', $filterPublicationDateTo,
                        ['class' => 'form-control form-control-sm mt-1', 'placeholder' => 'To...',
                        'wire:model.defer' => 'filterPublicationDateTo',
                        'wire:keydown.enter' => 'loadBooks']) !!}
                    @error('filterPublicationDateTo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </td>
            <td>
                {!! Form::select('filterGenre', $genres, $filterGenre,
                    ['class' => 'form-select form-select-sm', 'wire:model' => 'filterGenre','placeholder' => 'Select genre']) !!}
                @error('filterGenre') <span class="text-danger">{{ $message }}</span> @enderror
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span>Number of Copies</span>
                    {!! Form::number('filterCopiesFrom', $filterCopiesFrom,
                        ['class' => 'form-control form-control-sm mt-1', 'placeholder' => 'From...',
                        'wire:model.defer' => 'filterCopiesFrom',
                        'wire:keydown.enter' => 'loadBooks']) !!}
                    @error('filterCopiesFrom') <span class="text-danger">{{ $message }}</span> @enderror
                    {!! Form::number('filterCopiesTo', $filterCopiesTo,
                        ['class' => 'form-control form-control-sm mt-1', 'placeholder' => 'To...',
                        'wire:model.defer' => 'filterCopiesTo',
                        'wire:keydown.enter' => 'loadBooks']) !!}
                    @error('filterCopiesTo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </td>
            <td class="text-center">
                <div class="d-flex align-items-center">
                    {!! Form::button('Search', ['class' => 'btn btn-primary btn-sm me-2', 'wire:click' => 'loadBooks']) !!}
                    @if($searchTitle || $filterAuthor || $searchIsbn || $filterGenre || $filterCopiesFrom || $filterCopiesTo || $filterPublicationDateFrom || $filterPublicationDateTo)
                        <button wire:click="resetFilters" class="btn btn-secondary btn-sm">Reset</button>
                    @endif
                </div>
            </td>
        </tr>

        <tr>
            <th class="table-header" wire:click="sortBy('title')">
                Title
                @include('livewire.partials.sort-icon', ['field' => 'title'])
            </th>
            <th class="table-header">
                Author
            </th>
            <th class="table-header" wire:click="sortBy('isbn')">
                ISBN
                @include('livewire.partials.sort-icon', ['field' => 'isbn'])
            </th>
            <th class="table-header" wire:click="sortBy('publication_date')">
                Publication date
                @include('livewire.partials.sort-icon', ['field' => 'publication_date'])
            </th>
            <th class="table-header">
                Genre
            </th>
            <th class="table-header" wire:click="sortBy('number_of_copies')">
                Number of copies
                @include('livewire.partials.sort-icon', ['field' => 'number_of_copies'])
            </th>
            <th class="table-header text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>
                    @foreach ($book->authors as $index => $author)
                        {{ $author->name }}@if ($index < $book->authors->count() - 1),<br>@endif
                    @endforeach
                </td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->publication_date }}</td>
                <td>
                    @foreach ($book->genres as $index => $genre)
                        {{ $genre->name }}@if ($index < $book->genres->count() - 1),<br>@endif
                    @endforeach
                </td>
                <td>{{ $book->number_of_copies }}</td>
                <td class="text-end">
                    <div class="btn-group" role="group">
                        <button wire:click="edit({{ $book->id }})" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="delete({{ $book->id }})" class="btn btn-danger btn-sm d-flex align-items-center gap-2"
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
